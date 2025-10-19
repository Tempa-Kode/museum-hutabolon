@extends("home.template")
@section("title", "Galery/Situs Sejarah")

@push("styles")
    <link rel="stylesheet" href="{{ asset("css/styles.css") }}">
@endpush

@section("body")
    <!--======= HOME MAIN SLIDER =========-->
    <section class="sub-bnr sub-gallery" data-stellar-background-ratio="0.3">
        <div class="overlay-gr">
            <div class="container">
                <h2>Detail Situs Sejarah</h2>
                <h2>~ {{ $data->nama }} ~</h2>
            </div>
        </div>
    </section>
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route("home") }}">Home</a></li>
        <li class="active">Detail Gallery/Situs Sejarah</li>
    </ol>

    <div class="content">
        <section class="sec-100px gallery bg-white">
            <div class="container">
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
                                            <i class="align-middle" data-feather="image"
                                                style="width: 48px; height: 48px;"></i>
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
                                                <i class="fa-solid fa-left-long"></i>
                                            </button>
                                            <div class="thumbnail-wrapper">
                                                <div class="thumbnail-track" id="thumbnailTrack">
                                                    @foreach ($data->gambarVideo as $index => $item)
                                                        <div class="thumbnail-item {{ $firstImageId && $item->id === $firstImageId ? "active" : "" }}"
                                                            data-index="{{ $index }}" data-type="{{ $item->jenis }}"
                                                            data-link="{{ $item->link }}" data-id="{{ $item->id }}"
                                                            @if ($item->jenis === "gambar") data-fullsrc="{{ asset($item->link) }}" @endif>

                                                            @if ($item->jenis === "gambar")
                                                                <img src="{{ asset($item->link) }}"
                                                                    alt="Thumbnail {{ $index + 1 }}"
                                                                    class="thumbnail-img">
                                                            @else
                                                                @php
                                                                    $videoUrl = $item->link;
                                                                    $videoId = "";
                                                                    if (
                                                                        strpos($videoUrl, "youtube.com/watch?v=") !==
                                                                        false
                                                                    ) {
                                                                        parse_str(
                                                                            parse_url($videoUrl, PHP_URL_QUERY),
                                                                            $params,
                                                                        );
                                                                        $videoId = $params["v"] ?? "";
                                                                    } elseif (
                                                                        strpos($videoUrl, "youtu.be/") !== false
                                                                    ) {
                                                                        $videoId = substr(
                                                                            parse_url($videoUrl, PHP_URL_PATH),
                                                                            1,
                                                                        );
                                                                    } elseif (
                                                                        strpos($videoUrl, "youtube.com/embed/") !==
                                                                        false
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
                                                <i class="fa-solid fa-right-long"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h2 class="fw-bold">{{  $data->nama }}</h2>
                                </div>
                                <div class="mb-4">
                                    <h6 class="text-muted fw-bold">Kategori</h6>
                                    <div>
                                        @forelse ($data->kategori as $kategori)
                                            <span class="badge bg-primary me-1 mb-1">{{ $kategori->nama_kategori }}</span>
                                        @empty
                                            <span class="text-muted">Tidak ada kategori</span>
                                        @endforelse
                                    </div>
                                </div>

                                @if ($data->deskripsi_konten)
                                    <div class="mb-4">
                                        <h6 class="text-muted fw-bold">Deskripsi</h6>
                                        <div class="content-description">
                                            {!! $data->deskripsi_konten !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                               <button class="btn btn-outline-danger"
                                        style="margin-left: 20px"
                                        id="favoriteBtn"
                                        data-id="{{ $data->id }}"
                                        data-nama="{{ $data->nama }}"
                                        data-gambar="{{ $data->gambarVideo->first() ? asset($data->gambarVideo->first()->link) : '' }}"
                                        data-kategori="{{ $data->kategori->pluck('nama_kategori')->implode(', ') }}"
                                        data-slug="{{ $data->slug }}"
                                        data-type="gallery">
                                    <i class="fa-regular fa-heart"></i>
                                    Favoritkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="width: 100%; border: 1px solid #eee;">

                {{-- Comment Section --}}
                <div class="comments-section mt-4">
                    <h4 class="mb-3 fw-bold">Komentar</h4>
                    @if ($data->komentar->count() > 0)
                        @foreach ($data->komentar as $komentar)
                            <div class="mb-3">
                                <h6 class="fw-bold">{{ $komentar->nama }}</h6>
                                <p>{{ $komentar->komentar }}</p>
                                <p><small class="text-muted">{{ $komentar->created_at->diffForHumans() }}</small></p>
                                <hr>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Belum ada komentar untuk situs sejarah ini.</p>
                    @endif
                </div>

                {{-- Input/Tambah Komentar --}}
                <div class="input-comment" style="margin-top: 40px">
                    <h4 class="mb-3 fw-bold">Tambah Komentar</h4>
                    <form action="{{ route('gallery.tambah-komentar', $data->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" style="border: .5px solid #6e6e6e; border-radius: 4px;" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3" style="margin-top: 15px">
                            <label for="komentar" class="form-label">Komentar</label>
                            <textarea class="form-control" style="border: .5px solid #6e6e6e; border-radius: 4px;" id="komentar" name="komentar" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="float: inline-end">
                            <i class="fa-solid fa-paper-plane" style="margin-right: 5px"></i>
                            Kirim Komentar
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push("scripts")
    <script src="{{ asset("js/script.js") }}"></script>
    <script src="{{ asset("js/favorit.js") }}"></script>
@endpush
