@extends("template")
@section("title", "Data Komentar")
@section("title-page", "Data Komentar")
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
                    <div class="table-responsive">
                        <table class="table datatable table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Situs Sejarah/Gallery</th>
                                    <th>Nama</th>
                                    <th>Komentar</th>
                                    <th>Diinput Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('situs-sejarah.show', $item->situsSejarah->slug) }}">{{ $item->situsSejarah->nama ?? '-' }}</a>
                                        </td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->komentar }}</td>
                                        <td>{{ $item->created_at->diffForHumans() }}</td>
                                        <td>
                                            <form action="{{ route('komentar.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
