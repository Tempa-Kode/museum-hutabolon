@extends("template")
@section("title", "Data Event")
@section("title-page", "Data Event")
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
                    <a href="{{ route('event.create') }}" class="btn btn-primary">Tambah Data</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatable table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Event</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Diinput Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_event }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_event)->translatedFormat('d F Y') }}</td>
                                        <td>
                                            @if($item->waktu_event)
                                                {{ \Carbon\Carbon::parse($item->waktu_event)->format('H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('event.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('event.destroy', $item->id) }}" method="POST" style="display:inline;">
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
