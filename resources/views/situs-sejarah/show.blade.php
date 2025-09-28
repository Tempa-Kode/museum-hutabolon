@extends("template")
@section("title", "Detail Situs Sejarah")
@section("title-page", $data->nama)
@section("body")
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            @forelse ($data->gambarVideo as $item)
                                @if ($item->jenis === 'gambar')
                                    <img src="{{ asset($item->link) }}" alt="Gambar Situs Sejarah" class="img-fluid mb-3">
                                @elseif ($item->jenis === 'video')
                                    <div class="ratio ratio-16x9 mb-3">
                                        @php
                                            // Extract YouTube video ID from various URL formats
                                            $videoUrl = $item->link;
                                            $videoId = '';

                                            if (strpos($videoUrl, 'youtube.com/watch?v=') !== false) {
                                                parse_str(parse_url($videoUrl, PHP_URL_QUERY), $params);
                                                $videoId = $params['v'] ?? '';
                                            } elseif (strpos($videoUrl, 'youtu.be/') !== false) {
                                                $videoId = substr(parse_url($videoUrl, PHP_URL_PATH), 1);
                                            } elseif (strpos($videoUrl, 'youtube.com/embed/') !== false) {
                                                $videoId = substr(parse_url($videoUrl, PHP_URL_PATH), 7);
                                            }

                                            $embedUrl = $videoId ? "https://www.youtube.com/embed/{$videoId}" : $videoUrl;
                                        @endphp

                                        <iframe
                                            src="{{ $embedUrl }}"
                                            title="YouTube video player"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            allowfullscreen
                                            class="rounded">
                                        </iframe>
                                    </div>
                                @endif
                            @empty
                                <div class="text-muted">
                                    <i class="align-middle" data-feather="image"></i>
                                    <p>Tidak ada gambar atau video tersedia</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <h5 class="text-muted">Lokasi</h5>
                                <p>{{ $data->lokasi }}</p>
                            </div>

                            <div class="mb-3">
                                <h5 class="text-muted">Kategori</h5>
                                <div>
                                    @forelse ($data->kategori as $kategori)
                                        <span class="badge bg-primary me-1">{{ $kategori->nama_kategori }}</span>
                                    @empty
                                        <span class="text-muted">Tidak ada kategori</span>
                                    @endforelse
                                </div>
                            </div>

                            @if($data->deskripsi_konten)
                            <div class="mb-3">
                                <h5 class="text-muted">Deskripsi</h5>
                                <div class="content-description">
                                    {!! $data->deskripsi_konten !!}
                                </div>
                            </div>
                            @endif

                            <div class="mb-3">
                                <a href="{{ route('situs-sejarah.index') }}" class="btn btn-secondary">
                                    <i class="align-middle" data-feather="arrow-left"></i>
                                    Kembali ke Daftar
                                </a>
                                <a href="{{ route('situs-sejarah.edit', $data->slug) }}" class="btn btn-primary">
                                    <i class="align-middle" data-feather="edit"></i>
                                    Edit Data
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mt-4">Komentar</h4>
                        </div>
                        <div class="col-12">
                            @if($data->komentar->isEmpty())
                                <p class="text-muted">Tidak ada komentar</p>
                            @else
                                @foreach($data->komentar as $komentar)
                                    <div class="border-bottom py-3">
                                        <h5 class="mb-1">{{ $komentar->user->nama }}</h5>
                                        <p class="mb-1">{{ $komentar->komentar }}</p>
                                        <small class="text-muted">{{ $komentar->created_at->diffForHumans() }}</small>
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

@push('styles')
<style>
.content-description {
    line-height: 1.6;
}
.content-description p {
    margin-bottom: 1rem;
}
.content-description h1, .content-description h2, .content-description h3 {
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}
.content-description ul, .content-description ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}
</style>
@endpush
