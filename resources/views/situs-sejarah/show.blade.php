@extends("template")
@section("title", "Detail Situs Sejarah")
@section("title-page", $data->nama)
@section("body")
    <div class="row">
        <div class="col-12">
            @if (session("success"))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <strong>Berhasil!</strong> {{ session("success") }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (session("error"))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <strong>Error!</strong> {{ session("error") }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            {{-- Main Media Display --}}
                            <div class="main-media-container mb-3">
                                @php
                                    $firstItem = $data->gambarVideo->first();

                                    // Helper: ekstrak ID & start time YouTube
                                    $youtubeId = null;
                                    $start = null; // dalam detik

                                    if ($firstItem && $firstItem->jenis === "vidio") {
                                        $url = trim($firstItem->link ?? "");

                                        // Normalisasi URL
                                        $host = parse_url($url, PHP_URL_HOST) ?? "";
                                        $path = parse_url($url, PHP_URL_PATH) ?? "";
                                        $query = parse_url($url, PHP_URL_QUERY) ?? "";
                                        parse_str($query, $q);

                                        // 1) youtube.com/watch?v=XXXXXXXXXXX
                                        if (strpos($host, "youtube.com") !== false && isset($q["v"])) {
                                            $youtubeId = $q["v"];
                                        }
                                        // 2) youtu.be/XXXXXXXXXXX
                                        elseif (strpos($host, "youtu.be") !== false) {
                                            $youtubeId = ltrim($path, "/");
                                        }
                                        // 3) youtube.com/embed/XXXXXXXXXXX
                                        elseif (
                                            strpos($host, "youtube.com") !== false &&
                                            strpos($path, "/embed/") === 0
                                        ) {
                                            $youtubeId = substr($path, strlen("/embed/"));
                                        }
                                        // 4) youtube.com/shorts/XXXXXXXXXXX
                                        elseif (
                                            strpos($host, "youtube.com") !== false &&
                                            strpos($path, "/shorts/") === 0
                                        ) {
                                            $youtubeId = substr($path, strlen("/shorts/"));
                                        }

                                        // Ambil waktu mulai: ?t=90 atau &start=90
                                        if (isset($q["t"])) {
                                            // dukung format 1m30s, 90, 01:30
                                            $t = $q["t"];
                                            if (preg_match('/^(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?$/', $t, $m)) {
                                                $h = (int) ($m[1] ?? 0);
                                                $mn = (int) ($m[2] ?? 0);
                                                $s = (int) ($m[3] ?? 0);
                                                $start = $h * 3600 + $mn * 60 + $s;
                                            } elseif (preg_match('/^(\d+):(\d+)$/', $t, $m)) {
                                                $start = ((int) $m[1]) * 60 + (int) $m[2];
                                            } elseif (ctype_digit($t)) {
                                                $start = (int) $t;
                                            }
                                        } elseif (isset($q["start"]) && ctype_digit((string) $q["start"])) {
                                            $start = (int) $q["start"];
                                        }
                                    }

                                    // Siapkan URL embed YouTube
                                    $embedUrl = $youtubeId
                                        ? "https://www.youtube-nocookie.com/embed/" .
                                            $youtubeId .
                                            "?" .
                                            http_build_query([
                                                "rel" => 0,
                                                "modestbranding" => 1,
                                                "hl" => "id",
                                                "start" => $start ?? 0,
                                                // 'autoplay' => 1, // aktifkan jika ingin langsung play
                                            ])
                                        : null;
                                @endphp

                                @if ($firstItem)
                                    <div id="mainMediaDisplay" class="main-media-display">
                                        @if ($firstItem->jenis === "gambar")
                                            <img src="{{ asset($firstItem->link) }}" alt="Gambar Situs Sejarah"
                                                class="img-fluid rounded main-image" id="mainImage">
                                        @elseif ($firstItem->jenis === "vidio" && $embedUrl)
                                            <div class="ratio ratio-16x9" id="mainVideo">
                                                <iframe src="{{ $embedUrl }}" title="YouTube video player"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen class="rounded">
                                                </iframe>
                                            </div>
                                        @elseif ($firstItem->jenis === "vidio")
                                            {{-- Fallback: jika bukan YouTube, tampilkan link --}}
                                            <div class="text-center text-muted p-4">
                                                <i class="align-middle" data-feather="link"
                                                    style="width: 48px; height: 48px;"></i>
                                                <p class="mt-2 mb-1">Video tidak dapat dimuat sebagai embed.</p>
                                                <a href="{{ $firstItem->link }}" target="_blank" rel="noopener"
                                                    class="btn btn-primary">
                                                    <i class="align-middle" data-feather="external-link"></i>
                                                    Buka Video
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center text-muted p-4" id="mainMediaDisplay">
                                        <i class="align-middle" data-feather="image" style="width: 48px; height: 48px;"></i>
                                        <p class="mt-2">Tidak ada media tersedia</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Thumbnail Gallery -->
                            @if ($data->gambarVideo->count() > 1)
                                @php
                                    $firstImage = $data->gambarVideo->firstWhere("jenis", "gambar");
                                    $firstImageId = $firstImage->id ?? null;
                                @endphp
                                <div class="thumbnail-gallery">
                                    <div class="thumbnail-container">
                                        <button class="thumbnail-nav prev-btn" id="prevBtn">
                                            <i data-feather="chevron-left"></i>
                                        </button>
                                        <div class="thumbnail-wrapper">
                                            <div class="thumbnail-track" id="thumbnailTrack">
                                                @foreach ($data->gambarVideo as $index => $item)
                                                    <div class="thumbnail-item {{ $firstImageId && $item->id === $firstImageId ? "active" : "" }}"
                                                        data-index="{{ $index }}" data-type="{{ $item->jenis }}"
                                                        data-link="{{ $item->link }}" data-id="{{ $item->id }}"
                                                        @if ($item->jenis === "gambar") data-fullsrc="{{ asset($item->link) }}" @endif>

                                                        <!-- Delete Button -->
                                                        <button type="button" class="delete-media-btn"
                                                            data-id="{{ $item->id }}" data-type="{{ $item->jenis }}"
                                                            title="Hapus {{ $item->jenis === "gambar" ? "Gambar" : "Video" }}">
                                                            <i data-feather="x"></i>
                                                        </button>

                                                        @if ($item->jenis === "gambar")
                                                            <img src="{{ asset($item->link) }}"
                                                                alt="Thumbnail {{ $index + 1 }}" class="thumbnail-img">
                                                        @else
                                                            @php
                                                                $videoUrl = $item->link;
                                                                $videoId = "";
                                                                if (
                                                                    strpos($videoUrl, "youtube.com/watch?v=") !== false
                                                                ) {
                                                                    parse_str(
                                                                        parse_url($videoUrl, PHP_URL_QUERY),
                                                                        $params,
                                                                    );
                                                                    $videoId = $params["v"] ?? "";
                                                                } elseif (strpos($videoUrl, "youtu.be/") !== false) {
                                                                    $videoId = substr(
                                                                        parse_url($videoUrl, PHP_URL_PATH),
                                                                        1,
                                                                    );
                                                                } elseif (
                                                                    strpos($videoUrl, "youtube.com/embed/") !== false
                                                                ) {
                                                                    $videoId = substr(
                                                                        parse_url($videoUrl, PHP_URL_PATH),
                                                                        7,
                                                                    );
                                                                }
                                                                $thumbnailUrl = $videoId
                                                                    ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg"
                                                                    : "";
                                                            @endphp
                                                            <div class="video-thumbnail"
                                                                title="Klik untuk membuka video di tab baru">
                                                                <img src="{{ $thumbnailUrl }}"
                                                                    alt="Video Thumbnail {{ $index + 1 }}"
                                                                    class="thumbnail-img">
                                                                <div class="play-overlay">
                                                                    <i data-feather="play"></i>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <button class="thumbnail-nav next-btn" id="nextBtn">
                                            <i data-feather="chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <h5 class="text-muted fw-bold">Lokasi</h5>
                                <p class="mb-0">{{ $data->lokasi }}</p>
                            </div>

                            <div class="mb-3">
                                <h5 class="text-muted fw-bold">Kategori</h5>
                                <div>
                                    @forelse ($data->kategori as $kategori)
                                        <span class="badge bg-primary me-1 mb-1">{{ $kategori->nama_kategori }}</span>
                                    @empty
                                        <span class="text-muted">Tidak ada kategori</span>
                                    @endforelse
                                </div>
                            </div>

                            @if ($data->deskripsi_konten)
                                <div class="mb-3">
                                    <h5 class="text-muted fw-bold">Deskripsi</h5>
                                    <div class="content-description">
                                        {!! $data->deskripsi_konten !!}
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <a href="{{ route("situs-sejarah.index") }}" class="btn btn-secondary me-2 mb-2">
                                    <i class="align-middle" data-feather="arrow-left"></i>
                                    Kembali ke Daftar
                                </a>
                                <a href="{{ route("situs-sejarah.edit", $data->slug) }}" class="btn btn-primary me-2 mb-2">
                                    <i class="align-middle" data-feather="edit"></i>
                                    Edit Data
                                </a>
                                <a href="{{ route("situs-sejarah.tambah-vidgam", $data->slug) }}"
                                    class="btn btn-success mb-2">
                                    <i class="align-middle" data-feather="plus"></i>
                                    Tambah Media
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Komentar Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4 class="mb-3">Komentar</h4>
                            @if ($data->komentar->isEmpty())
                                <div class="text-center text-muted p-4">
                                    <i class="align-middle" data-feather="message-circle"
                                        style="width: 48px; height: 48px;"></i>
                                    <p class="mt-2">Tidak ada komentar</p>
                                </div>
                            @else
                                @foreach ($data->komentar->sortByDesc('created_at') as $komentar)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h6 class="card-title mb-1">{{ $komentar->nama }}</h6>
                                            <p class="card-text">{{ $komentar->komentar }}</p>
                                            <small class="text-muted">{{ $komentar->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("styles")
    <style>
        .content-description {
            line-height: 1.6;
        }

        .content-description p {
            margin-bottom: 1rem;
        }

        .content-description h1,
        .content-description h2,
        .content-description h3 {
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .content-description ul,
        .content-description ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }

        /* Gallery Styles */
        .main-media-container {
            position: relative;
            min-height: 400px;
            background: #f8f9fa;
            border-radius: 0.5rem;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-media-display {
            width: 100%;
            height: 400px;
            position: relative;
        }

        .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .ratio.ratio-16x9 {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .ratio.ratio-16x9 iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 0.5rem;
        }

        .thumbnail-gallery {
            margin-top: 1rem;
        }

        .thumbnail-container {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .thumbnail-wrapper {
            flex: 1;
            overflow: hidden;
            border-radius: 0.375rem;
        }

        .thumbnail-track {
            display: flex;
            gap: 0.5rem;
            transition: transform 0.3s ease;
            padding: 0.25rem;
        }

        .thumbnail-item {
            flex: 0 0 80px;
            height: 60px;
            border-radius: 0.375rem;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            position: relative;
        }

        /* Delete Button Styles */
        .delete-media-btn {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 20px;
            height: 20px;
            background: rgba(220, 53, 69, 0.9);
            border: none;
            border-radius: 50%;
            color: white;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.2s ease;
            font-size: 12px;
        }

        .delete-media-btn:hover {
            background: #dc3545;
            transform: scale(1.1);
        }

        .thumbnail-item:hover .delete-media-btn {
            display: flex;
        }

        /* Loading state saat delete */
        .thumbnail-item.deleting {
            opacity: 0.5;
            pointer-events: none;
        }

        .thumbnail-item.deleting::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #ccc;
            border-top: 2px solid #dc3545;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Delete Button Styles */
        .delete-media-btn {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 20px;
            height: 20px;
            background: rgba(220, 53, 69, 0.9);
            border: none;
            border-radius: 50%;
            color: white;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.2s ease;
            font-size: 12px;
        }

        .delete-media-btn:hover {
            background: #dc3545;
            transform: scale(1.1);
        }

        .thumbnail-item:hover .delete-media-btn {
            display: flex;
        }

        .thumbnail-item:hover {
            border-color: #0d6efd;
            transform: scale(1.05);
        }

        .thumbnail-item.active {
            border-color: #0d6efd;
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
        }

        .thumbnail-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-thumbnail {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .play-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .thumbnail-nav {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .thumbnail-nav:hover {
            background: #f8f9fa;
            border-color: #0d6efd;
            color: #0d6efd;
        }

        .thumbnail-nav:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-image {
                height: 250px;
            }

            .thumbnail-item {
                flex: 0 0 60px;
                height: 45px;
            }

            .thumbnail-nav {
                width: 30px;
                height: 30px;
            }
        }
    </style>
@endpush

@push("scripts")
    <script>
        $(document).ready(function() {
            // Handle media type selection
            $('#jenis').change(function() {
                const selectedType = $(this).val();
                if (selectedType === 'gambar') {
                    $('#upload-gambar').slideDown();
                    $('#link-video').slideUp();
                    $('#video_url').removeAttr('required');
                    $('#gambar').attr('required', 'required');
                } else if (selectedType === 'video') {
                    $('#link-video').slideDown();
                    $('#upload-gambar').slideUp();
                    $('#gambar').removeAttr('required');
                    $('#video_url').attr('required', 'required');
                } else {
                    $('#upload-gambar').slideUp();
                    $('#link-video').slideUp();
                    $('#gambar').removeAttr('required');
                    $('#video_url').removeAttr('required');
                }

                // Clear previews
                $('#image-preview').hide();
                $('#video-preview').hide();
            });

            // Image preview
            $('#gambar').change(function() {
                const file = this.files[0];
                if (file) {
                    if (file.size > 5 * 1024 * 1024) { // 5MB limit
                        alert('File terlalu besar. Maksimal 5MB.');
                        $(this).val('');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-preview img').attr('src', e.target.result);
                        $('#image-preview').fadeIn();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#image-preview').hide();
                }
            });

            // Video preview
            $('#video_url').on('input', function() {
                const url = $(this).val();
                if (url) {
                    const videoId = extractYouTubeId(url);
                    if (videoId) {
                        const embedUrl = `https://www.youtube.com/embed/${videoId}`;
                        $('#video-preview iframe').attr('src', embedUrl);
                        $('#video-preview').fadeIn();
                    } else {
                        $('#video-preview').hide();
                    }
                } else {
                    $('#video-preview').hide();
                }
            });

            function extractYouTubeId(url) {
                const regex =
                    /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
                const match = url.match(regex);
                return match ? match[1] : null;
            }

            // Clear form when modal is closed
            $('#addMediaModal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('#upload-gambar').hide();
                $('#link-video').hide();
                $('#image-preview').hide();
                $('#video-preview').hide();
                $('#jenis').val('');
            });

            // Form validation
            $('form').submit(function(e) {
                const jenis = $('#jenis').val();
                if (!jenis) {
                    e.preventDefault();
                    alert('Silakan pilih jenis media terlebih dahulu.');
                    return false;
                }

                if (jenis === 'gambar' && !$('#gambar').val()) {
                    e.preventDefault();
                    alert('Silakan pilih file gambar.');
                    return false;
                }

                if (jenis === 'video' && !$('#video_url').val()) {
                    e.preventDefault();
                    alert('Silakan masukkan link YouTube.');
                    return false;
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let currentIndex = 0;
            const thumbnailTrack = $('#thumbnailTrack');
            const thumbnailItems = $('.thumbnail-item');
            const itemWidth = 88; // 80px + 8px gap
            const mainDisplay = $('#mainMediaDisplay');

            // Set index awal ke thumbnail yang sudah active (gambar pertama)
            const $activeThumb = $('.thumbnail-item.active').first();
            if ($activeThumb.length) {
                currentIndex = parseInt($activeThumb.data('index')) || 0;
            } else {
                // Tidak ada gambar sama sekali -> biarkan placeholder
                currentIndex = 0;
            }

            updateNavigationButtons();

            // Delete media handler
            $(document).on('click', '.delete-media-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const mediaId = $(this).data('id');
                const mediaType = $(this).data('type');
                const $thumbnail = $(this).closest('.thumbnail-item');

                // Konfirmasi hapus
                const mediaTypeText = mediaType === 'gambar' ? 'gambar' : 'video';
                if (!confirm(`Apakah Anda yakin ingin menghapus ${mediaTypeText} ini?`)) {
                    return;
                }

                // Kirim request delete
                $.ajax({
                    url: `{{ $data->slug }}/hapus-media/${mediaId}`,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $thumbnail.addClass('deleting');
                        $(this).prop('disabled', true);
                    },
                    success: function(response) {
                        // Hapus thumbnail dari DOM
                        $thumbnail.fadeOut(300, function() {
                            $(this).remove();

                            // Update gallery
                            updateGalleryAfterDelete();

                            // Show success message
                            showAlert('success', 'Media berhasil dihapus!');
                        });
                    },
                    error: function(xhr) {
                        $thumbnail.removeClass('deleting');
                        $(this).prop('disabled', false);

                        let errorMessage = 'Gagal menghapus media.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        showAlert('error', errorMessage);
                    }
                });
            });

            updateNavigationButtons();

            // Klik thumbnail
            $('.thumbnail-item').on('click', function(e) {
                // Jangan trigger jika yang diklik adalah tombol delete
                if ($(e.target).closest('.delete-media-btn').length) {
                    return;
                }

                const index = parseInt($(this).data('index'));
                const type = $(this).data('type');
                const link = $(this).data('link');

                console.log('Thumbnail clicked:', {
                    index,
                    type,
                    link
                });

                if (type === 'vidio') {
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
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }
                    }

                    // Update active state
                    $('.thumbnail-item').removeClass('active');
                    $(this).addClass('active');

                    currentIndex = index;
                    scrollToThumbnail(currentIndex);
                    updateNavigationButtons();
                    return;
                }

                // Hanya gambar yang boleh mengganti Main Media
                $('.thumbnail-item').removeClass('active');
                $(this).addClass('active');

                const fullSrc = $(this).data('fullsrc') || (window.location.origin + '/' + link);

                mainDisplay.html(`
            <img src="${fullSrc}" alt="Gambar Situs Sejarah"
                 class="img-fluid rounded main-image">
        `);

                currentIndex = index;
                scrollToThumbnail(currentIndex);
                updateNavigationButtons();
            });

            // Navigasi
            $('#prevBtn').click(function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    scrollToThumbnail(currentIndex);
                    updateNavigationButtons();
                }
            });

            $('#nextBtn').click(function() {
                if (currentIndex < thumbnailItems.length - 1) {
                    currentIndex++;
                    scrollToThumbnail(currentIndex);
                    updateNavigationButtons();
                }
            });

            function scrollToThumbnail(index) {
                const translateX = -index * itemWidth;
                thumbnailTrack.css('transform', `translateX(${translateX}px)`);
            }

            function updateNavigationButtons() {
                const visibleItems = Math.floor(thumbnailTrack.parent().width() / itemWidth);
                $('#prevBtn').prop('disabled', currentIndex <= 0);
                $('#nextBtn').prop('disabled', currentIndex >= thumbnailItems.length - visibleItems);
            }

            function extractYouTubeId(url) {
                if (!url) return null;

                const patterns = [
                    /(?:youtube\.com\/watch\?v=)([^&\n?#]+)/,
                    /(?:youtube\.com\/embed\/)([^&\n?#]+)/,
                    /(?:youtu\.be\/)([^&\n?#]+)/,
                    /(?:youtube\.com\/v\/)([^&\n?#]+)/,
                    /(?:youtube\.com\/shorts\/)([^&\n?#]+)/
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

            thumbnailTrack.on('touchstart mousedown', function(e) {
                startX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
                isDragging = true;
                e.preventDefault();
            });

            $(document).on('touchmove mousemove', function(e) {
                if (!isDragging) return;

                currentX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
                const diffX = startX - currentX;

                if (Math.abs(diffX) > 50) { // Minimum swipe distance
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

            $(document).on('touchend mouseup', function() {
                isDragging = false;
            });

            // Helper functions
            function updateGalleryAfterDelete() {
                // Update thumbnail items reference
                const updatedItems = $('.thumbnail-item');

                // Re-index thumbnails
                updatedItems.each(function(newIndex) {
                    $(this).attr('data-index', newIndex);
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
                    $('.thumbnail-gallery').fadeOut();

                    // Re-initialize feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                } else {
                    // If active item was deleted, activate first image
                    if (!$('.thumbnail-item.active').length) {
                        const firstImage = updatedItems.filter('[data-type="gambar"]').first();
                        if (firstImage.length) {
                            firstImage.trigger('click');
                        }
                    }

                    // Update current index
                    const activeIndex = $('.thumbnail-item.active').attr('data-index');
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
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const alertIcon = type === 'success' ? 'Berhasil!' : 'Error!';

                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                        <strong>${alertIcon}</strong> ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;

                // Insert alert at top of card
                $('.card-body').prepend(alertHtml);

                // Auto hide after 5 seconds
                setTimeout(function() {
                    $('.alert').fadeOut();
                }, 5000);
            }
        });
    </script>
@endpush
