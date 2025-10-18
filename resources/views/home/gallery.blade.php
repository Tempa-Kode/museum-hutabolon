@php
    use Illuminate\Support\Str;
@endphp
@extends("home.template")
@section("title", "Beranda")
@section("body")
    <!--======= HOME MAIN SLIDER =========-->
    <section class="sub-bnr sub-gallery" data-stellar-background-ratio="0.3">
        <div class="overlay-gr">
            <div class="container">
                <h2>Gallery Situs Sejarah</h2>
            </div>
        </div>
    </section>
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route("home") }}">Home</a></li>
        <li class="active">Gallery/Situs Sejarah</li>
    </ol>

    <div class="content">

        <!--======= Gallery =========-->
        <section class="sec-100px gallery bg-white">
            <div class="container">
                <div class="mb-3" style="margin-bottom: 30px;">
                    <form action="{{ route('gallery') }}" method="GET">
                        <div class="row mb-5 align-items-end">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-4">
                                <select name="kategori" class="form-control border border-secondary">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategori as $kat)
                                        <option value="{{ $kat->nama_kategori }}" {{ request('kategori') == $kat->nama_kategori ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100" style="margin-top: -2px; width:100%;">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
                <ul class="row">

                    <!-- Item 1 -->
                    @forelse ($gallery as $item)
                        <li class="col-sm-4">
                            <div class="inn-sec"> <span class="tag">{{ Str::limit($item->kategori->first()->nama_kategori, 30, "...") }}</span>
                                <img class="img-responsive" src="{{ asset($item->gambarVideo->where('jenis', 'gambar')->first()->link ?? 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg') }}"
                                alt=""
                                style="height: 300px; object-fit: cover;">
                                <div class="detail">
                                    <a href="#.">{{ $item->nama }}</a>
                                    <p><span>Lokasi</span>: {{ $item->lokasi }}</p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="col-sm-12">
                            <div class="inn-sec text-center">
                                <p>No gallery items found.</p>
                            </div>
                        </li>
                    @endforelse

                </ul>
                <ul class="pagination">
                    {{ $gallery->links() }}
                </ul>
            </div>
        </section>
    </div>
@endsection
