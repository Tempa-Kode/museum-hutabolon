@extends("template")
@section("title", "Data Situs Sejarah")
@section("title-page", "Data Situs Sejarah")
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
                <div class="card-header">
                    <a href="{{ route('situs-sejarah.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatable table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Nama</th>
                                    <th>Jumlah Penelusuran</th>
                                    <th>Diinput Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @foreach ($item->kategori as $kat)
                                                <span class="badge bg-info">{{ $kat->nama_kategori }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->totalPencarian->jlh_pencarian ?? 0 }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ route('situs-sejarah.show', $item->slug) }}" class="btn btn-secondary btn-sm">
                                                <i class="align-middle me-1" data-feather="eye"></i>
                                            </a>
                                            <a href="{{ route('situs-sejarah.edit', $item->slug) }}" class="btn btn-warning btn-sm">
                                                <i class="align-middle me-1" data-feather="edit"></i>
                                            </a>
                                            <form action="{{ route('situs-sejarah.destroy', $item->slug) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="align-middle me-1" data-feather="trash-2"></i>
                                                </button>
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
