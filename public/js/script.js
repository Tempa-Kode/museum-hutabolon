$(document).ready(function () {
    // Handle media type selection
    $("#jenis").change(function () {
        const selectedType = $(this).val();
        if (selectedType === "gambar") {
            $("#upload-gambar").slideDown();
            $("#link-video").slideUp();
            $("#video_url").removeAttr("required");
            $("#gambar").attr("required", "required");
        } else if (selectedType === "video") {
            $("#link-video").slideDown();
            $("#upload-gambar").slideUp();
            $("#gambar").removeAttr("required");
            $("#video_url").attr("required", "required");
        } else {
            $("#upload-gambar").slideUp();
            $("#link-video").slideUp();
            $("#gambar").removeAttr("required");
            $("#video_url").removeAttr("required");
        }

        // Clear previews
        $("#image-preview").hide();
        $("#video-preview").hide();
    });

    // Image preview
    $("#gambar").change(function () {
        const file = this.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                // 5MB limit
                alert("File terlalu besar. Maksimal 5MB.");
                $(this).val("");
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                $("#image-preview img").attr("src", e.target.result);
                $("#image-preview").fadeIn();
            };
            reader.readAsDataURL(file);
        } else {
            $("#image-preview").hide();
        }
    });

    // Video preview
    $("#video_url").on("input", function () {
        const url = $(this).val();
        if (url) {
            const videoId = extractYouTubeId(url);
            if (videoId) {
                const embedUrl = `https://www.youtube.com/embed/${videoId}`;
                $("#video-preview iframe").attr("src", embedUrl);
                $("#video-preview").fadeIn();
            } else {
                $("#video-preview").hide();
            }
        } else {
            $("#video-preview").hide();
        }
    });

    function extractYouTubeId(url) {
        const regex =
            /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
        const match = url.match(regex);
        return match ? match[1] : null;
    }

    // Clear form when modal is closed
    $("#addMediaModal").on("hidden.bs.modal", function () {
        $(this).find("form")[0].reset();
        $("#upload-gambar").hide();
        $("#link-video").hide();
        $("#image-preview").hide();
        $("#video-preview").hide();
        $("#jenis").val("");
    });
});

$(document).ready(function () {
    let currentIndex = 0;
    const thumbnailTrack = $("#thumbnailTrack");
    const thumbnailItems = $(".thumbnail-item");
    const itemWidth = 88; // 80px + 8px gap
    const mainDisplay = $("#mainMediaDisplay");

    // Set index awal ke thumbnail yang sudah active (gambar pertama)
    const $activeThumb = $(".thumbnail-item.active").first();
    if ($activeThumb.length) {
        currentIndex = parseInt($activeThumb.data("index")) || 0;
    } else {
        // Tidak ada gambar sama sekali -> biarkan placeholder
        currentIndex = 0;
    }

    updateNavigationButtons();

    // Delete media handler
    $(document).on("click", ".delete-media-btn", function (e) {
        e.preventDefault();
        e.stopPropagation();

        const mediaId = $(this).data("id");
        const mediaType = $(this).data("type");
        const $thumbnail = $(this).closest(".thumbnail-item");

        // Konfirmasi hapus
        const mediaTypeText = mediaType === "gambar" ? "gambar" : "video";
        if (
            !confirm(`Apakah Anda yakin ingin menghapus ${mediaTypeText} ini?`)
        ) {
            return;
        }

        // Kirim request delete
        $.ajax({
            url: `{{ $data->slug }}/hapus-media/${mediaId}`,
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                $thumbnail.addClass("deleting");
                $(this).prop("disabled", true);
            },
            success: function (response) {
                // Hapus thumbnail dari DOM
                $thumbnail.fadeOut(300, function () {
                    $(this).remove();

                    // Update gallery
                    updateGalleryAfterDelete();

                    // Show success message
                    showAlert("success", "Media berhasil dihapus!");
                });
            },
            error: function (xhr) {
                $thumbnail.removeClass("deleting");
                $(this).prop("disabled", false);

                let errorMessage = "Gagal menghapus media.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                showAlert("error", errorMessage);
            },
        });
    });

    updateNavigationButtons();

    // Klik thumbnail
    $(".thumbnail-item").on("click", function (e) {
        // Jangan trigger jika yang diklik adalah tombol delete
        if ($(e.target).closest(".delete-media-btn").length) {
            return;
        }

        const index = parseInt($(this).data("index"));
        const type = $(this).data("type");
        const link = $(this).data("link");

        console.log("Thumbnail clicked:", {
            index,
            type,
            link,
        });

        if (type === "vidio") {
            // Tampilkan video di Main Media Display
            const videoId = extractYouTubeId(link);
            if (videoId) {
                const embedUrl = `https://www.youtube.com/embed/${videoId}?enablejsapi=1&rel=0`;
                mainDisplay.html(`
                    <div class="ratio ratio-16x9">
                        <iframe src="${embedUrl}" title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen class="rounded">
                        </iframe>
                    </div>
                `);
            } else {
                // Fallback jika bukan YouTube
                mainDisplay.html(`
                    <div class="text-center text-muted p-4">
                        <i class="align-middle" data-feather="link" style="width: 48px; height: 48px;"></i>
                        <p class="mt-2 mb-1">Video tidak dapat dimuat sebagai embed.</p>
                        <a href="${link}" target="_blank" rel="noopener" class="btn btn-primary">
                            <i class="align-middle" data-feather="external-link"></i>
                            Buka Video
                        </a>
                    </div>
                `);

                // Re-initialize feather icons
                if (typeof feather !== "undefined") {
                    feather.replace();
                }
            }

            // Update active state
            $(".thumbnail-item").removeClass("active");
            $(this).addClass("active");

            currentIndex = index;
            scrollToThumbnail(currentIndex);
            updateNavigationButtons();
            return;
        }

        // Hanya gambar yang boleh mengganti Main Media
        $(".thumbnail-item").removeClass("active");
        $(this).addClass("active");

        const fullSrc =
            $(this).data("fullsrc") || window.location.origin + "/" + link;

        mainDisplay.html(`
            <img src="${fullSrc}" alt="Gambar Situs Sejarah"
                class="img-fluid rounded main-image">
        `);

        currentIndex = index;
        scrollToThumbnail(currentIndex);
        updateNavigationButtons();
    });

    // Navigasi
    $("#prevBtn").click(function () {
        if (currentIndex > 0) {
            currentIndex--;
            scrollToThumbnail(currentIndex);
            updateNavigationButtons();
        }
    });

    $("#nextBtn").click(function () {
        if (currentIndex < thumbnailItems.length - 1) {
            currentIndex++;
            scrollToThumbnail(currentIndex);
            updateNavigationButtons();
        }
    });

    function scrollToThumbnail(index) {
        const translateX = -index * itemWidth;
        thumbnailTrack.css("transform", `translateX(${translateX}px)`);
    }

    function updateNavigationButtons() {
        const visibleItems = Math.floor(
            thumbnailTrack.parent().width() / itemWidth
        );
        $("#prevBtn").prop("disabled", currentIndex <= 0);
        $("#nextBtn").prop(
            "disabled",
            currentIndex >= thumbnailItems.length - visibleItems
        );
    }

    function extractYouTubeId(url) {
        if (!url) return null;

        const patterns = [
            /(?:youtube\.com\/watch\?v=)([^&\n?#]+)/,
            /(?:youtube\.com\/embed\/)([^&\n?#]+)/,
            /(?:youtu\.be\/)([^&\n?#]+)/,
            /(?:youtube\.com\/v\/)([^&\n?#]+)/,
            /(?:youtube\.com\/shorts\/)([^&\n?#]+)/,
        ];

        for (let pattern of patterns) {
            const match = url.match(pattern);
            if (match && match[1]) {
                return match[1];
            }
        }

        return null;
    }

    function extractYouTubeId(url) {
        const regex =
            /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
        const match = url.match(regex);
        return match ? match[1] : null;
    }

    // Touch/swipe support for mobile
    let startX = 0;
    let currentX = 0;
    let isDragging = false;

    thumbnailTrack.on("touchstart mousedown", function (e) {
        startX = e.type === "touchstart" ? e.touches[0].clientX : e.clientX;
        isDragging = true;
        e.preventDefault();
    });

    $(document).on("touchmove mousemove", function (e) {
        if (!isDragging) return;

        currentX = e.type === "touchmove" ? e.touches[0].clientX : e.clientX;
        const diffX = startX - currentX;

        if (Math.abs(diffX) > 50) {
            // Minimum swipe distance
            if (diffX > 0 && currentIndex < thumbnailItems.length - 1) {
                // Swipe left - next
                currentIndex++;
                scrollToThumbnail(currentIndex);
                updateNavigationButtons();
            } else if (diffX < 0 && currentIndex > 0) {
                // Swipe right - prev
                currentIndex--;
                scrollToThumbnail(currentIndex);
                updateNavigationButtons();
            }
            isDragging = false;
        }
    });

    $(document).on("touchend mouseup", function () {
        isDragging = false;
    });

    // Helper functions
    function updateGalleryAfterDelete() {
        // Update thumbnail items reference
        const updatedItems = $(".thumbnail-item");

        // Re-index thumbnails
        updatedItems.each(function (newIndex) {
            $(this).attr("data-index", newIndex);
        });

        // Check if no media left
        if (updatedItems.length === 0) {
            mainDisplay.html(`
                <div class="text-center text-muted p-4">
                    <i class="align-middle" data-feather="image" style="width: 48px; height: 48px;"></i>
                    <p class="mt-2">Tidak ada media tersedia</p>
                </div>
            `);

            // Hide thumbnail gallery
            $(".thumbnail-gallery").fadeOut();

            // Re-initialize feather icons
            if (typeof feather !== "undefined") {
                feather.replace();
            }
        } else {
            // If active item was deleted, activate first image
            if (!$(".thumbnail-item.active").length) {
                const firstImage = updatedItems
                    .filter('[data-type="gambar"]')
                    .first();
                if (firstImage.length) {
                    firstImage.trigger("click");
                }
            }

            // Update current index
            const activeIndex = $(".thumbnail-item.active").attr("data-index");
            if (activeIndex !== undefined) {
                currentIndex = parseInt(activeIndex);
            } else {
                currentIndex = 0;
            }

            // Update navigation
            updateNavigationButtons();
        }
    }

    function showAlert(type, message) {
        const alertClass =
            type === "success" ? "alert-success" : "alert-danger";
        const alertIcon = type === "success" ? "Berhasil!" : "Error!";

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <strong>${alertIcon}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        // Insert alert at top of card
        $(".card-body").prepend(alertHtml);

        // Auto hide after 5 seconds
        setTimeout(function () {
            $(".alert").fadeOut();
        }, 5000);
    }
});

$(document).ready(function () {
    let currentIndex = 0;
    const thumbnailTrack = $("#thumbnailTrack");
    const thumbnailItems = $(".thumbnail-item");
    const itemWidth = 88; // 80px + 8px gap
    const mainDisplay = $("#mainMediaDisplay");

    // Set index awal ke thumbnail yang sudah active (gambar pertama)
    const $activeThumb = $(".thumbnail-item.active").first();
    if ($activeThumb.length) {
        currentIndex = parseInt($activeThumb.data("index")) || 0;
    } else {
        // Tidak ada gambar sama sekali -> biarkan placeholder
        currentIndex = 0;
    }

    updateNavigationButtons();

    // Delete media handler
    $(document).on("click", ".delete-media-btn", function (e) {
        e.preventDefault();
        e.stopPropagation();

        const mediaId = $(this).data("id");
        const mediaType = $(this).data("type");
        const $thumbnail = $(this).closest(".thumbnail-item");

        // Konfirmasi hapus
        const mediaTypeText = mediaType === "gambar" ? "gambar" : "video";
        if (
            !confirm(`Apakah Anda yakin ingin menghapus ${mediaTypeText} ini?`)
        ) {
            return;
        }

        // Kirim request delete
        $.ajax({
            url: `{{ $data->slug }}/hapus-media/${mediaId}`,
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                $thumbnail.addClass("deleting");
                $(this).prop("disabled", true);
            },
            success: function (response) {
                // Hapus thumbnail dari DOM
                $thumbnail.fadeOut(300, function () {
                    $(this).remove();

                    // Update gallery
                    updateGalleryAfterDelete();

                    // Show success message
                    showAlert("success", "Media berhasil dihapus!");
                });
            },
            error: function (xhr) {
                $thumbnail.removeClass("deleting");
                $(this).prop("disabled", false);

                let errorMessage = "Gagal menghapus media.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                showAlert("error", errorMessage);
            },
        });
    });

    updateNavigationButtons();

    // Klik thumbnail
    $(".thumbnail-item").on("click", function (e) {
        // Jangan trigger jika yang diklik adalah tombol delete
        if ($(e.target).closest(".delete-media-btn").length) {
            return;
        }

        const index = parseInt($(this).data("index"));
        const type = $(this).data("type");
        const link = $(this).data("link");

        console.log("Thumbnail clicked:", {
            index,
            type,
            link,
        });

        if (type === "vidio") {
            // Tampilkan video di Main Media Display
            const videoId = extractYouTubeId(link);
            if (videoId) {
                const embedUrl = `https://www.youtube.com/embed/${videoId}?enablejsapi=1&rel=0`;
                mainDisplay.html(`
                    <div class="ratio ratio-16x9">
                        <iframe src="${embedUrl}" title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen class="rounded">
                        </iframe>
                    </div>
                `);
            } else {
                // Fallback jika bukan YouTube
                mainDisplay.html(`
                    <div class="text-center text-muted p-4">
                        <i class="align-middle" data-feather="link" style="width: 48px; height: 48px;"></i>
                        <p class="mt-2 mb-1">Video tidak dapat dimuat sebagai embed.</p>
                        <a href="${link}" target="_blank" rel="noopener" class="btn btn-primary">
                            <i class="align-middle" data-feather="external-link"></i>
                            Buka Video
                        </a>
                    </div>
                `);

                // Re-initialize feather icons
                if (typeof feather !== "undefined") {
                    feather.replace();
                }
            }

            // Update active state
            $(".thumbnail-item").removeClass("active");
            $(this).addClass("active");

            currentIndex = index;
            scrollToThumbnail(currentIndex);
            updateNavigationButtons();
            return;
        }

        // Hanya gambar yang boleh mengganti Main Media
        $(".thumbnail-item").removeClass("active");
        $(this).addClass("active");

        const fullSrc =
            $(this).data("fullsrc") || window.location.origin + "/" + link;

        mainDisplay.html(`
            <img src="${fullSrc}" alt="Gambar Situs Sejarah"
                class="img-fluid rounded main-image">
        `);

        currentIndex = index;
        scrollToThumbnail(currentIndex);
        updateNavigationButtons();
    });

    // Navigasi
    $("#prevBtn").click(function () {
        if (currentIndex > 0) {
            currentIndex--;
            scrollToThumbnail(currentIndex);
            updateNavigationButtons();
        }
    });

    $("#nextBtn").click(function () {
        if (currentIndex < thumbnailItems.length - 1) {
            currentIndex++;
            scrollToThumbnail(currentIndex);
            updateNavigationButtons();
        }
    });

    function scrollToThumbnail(index) {
        const translateX = -index * itemWidth;
        thumbnailTrack.css("transform", `translateX(${translateX}px)`);
    }

    function updateNavigationButtons() {
        const visibleItems = Math.floor(
            thumbnailTrack.parent().width() / itemWidth
        );
        $("#prevBtn").prop("disabled", currentIndex <= 0);
        $("#nextBtn").prop(
            "disabled",
            currentIndex >= thumbnailItems.length - visibleItems
        );
    }

    function extractYouTubeId(url) {
        if (!url) return null;

        const patterns = [
            /(?:youtube\.com\/watch\?v=)([^&\n?#]+)/,
            /(?:youtube\.com\/embed\/)([^&\n?#]+)/,
            /(?:youtu\.be\/)([^&\n?#]+)/,
            /(?:youtube\.com\/v\/)([^&\n?#]+)/,
            /(?:youtube\.com\/shorts\/)([^&\n?#]+)/,
        ];

        for (let pattern of patterns) {
            const match = url.match(pattern);
            if (match && match[1]) {
                return match[1];
            }
        }

        return null;
    }

    function extractYouTubeId(url) {
        const regex =
            /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
        const match = url.match(regex);
        return match ? match[1] : null;
    }

    // Touch/swipe support for mobile
    let startX = 0;
    let currentX = 0;
    let isDragging = false;

    thumbnailTrack.on("touchstart mousedown", function (e) {
        startX = e.type === "touchstart" ? e.touches[0].clientX : e.clientX;
        isDragging = true;
        e.preventDefault();
    });

    $(document).on("touchmove mousemove", function (e) {
        if (!isDragging) return;

        currentX = e.type === "touchmove" ? e.touches[0].clientX : e.clientX;
        const diffX = startX - currentX;

        if (Math.abs(diffX) > 50) {
            // Minimum swipe distance
            if (diffX > 0 && currentIndex < thumbnailItems.length - 1) {
                // Swipe left - next
                currentIndex++;
                scrollToThumbnail(currentIndex);
                updateNavigationButtons();
            } else if (diffX < 0 && currentIndex > 0) {
                // Swipe right - prev
                currentIndex--;
                scrollToThumbnail(currentIndex);
                updateNavigationButtons();
            }
            isDragging = false;
        }
    });

    $(document).on("touchend mouseup", function () {
        isDragging = false;
    });

    // Helper functions
    function updateGalleryAfterDelete() {
        // Update thumbnail items reference
        const updatedItems = $(".thumbnail-item");

        // Re-index thumbnails
        updatedItems.each(function (newIndex) {
            $(this).attr("data-index", newIndex);
        });

        // Check if no media left
        if (updatedItems.length === 0) {
            mainDisplay.html(`
                <div class="text-center text-muted p-4">
                    <i class="align-middle" data-feather="image" style="width: 48px; height: 48px;"></i>
                    <p class="mt-2">Tidak ada media tersedia</p>
                </div>
            `);

            // Hide thumbnail gallery
            $(".thumbnail-gallery").fadeOut();

            // Re-initialize feather icons
            if (typeof feather !== "undefined") {
                feather.replace();
            }
        } else {
            // If active item was deleted, activate first image
            if (!$(".thumbnail-item.active").length) {
                const firstImage = updatedItems
                    .filter('[data-type="gambar"]')
                    .first();
                if (firstImage.length) {
                    firstImage.trigger("click");
                }
            }

            // Update current index
            const activeIndex = $(".thumbnail-item.active").attr("data-index");
            if (activeIndex !== undefined) {
                currentIndex = parseInt(activeIndex);
            } else {
                currentIndex = 0;
            }

            // Update navigation
            updateNavigationButtons();
        }
    }

    function showAlert(type, message) {
        const alertClass = type === "success" ? "alert-success" : "alert-danger";
        const alertIcon = type === "success" ? "Berhasil!" : "Error!";

        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <strong>${alertIcon}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        // Insert alert at top of card
        $(".card-body").prepend(alertHtml);

        // Auto hide after 5 seconds
        setTimeout(function () {
            $(".alert").fadeOut();
        }, 5000);
    }
});
