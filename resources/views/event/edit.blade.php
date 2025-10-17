@extends("template")
@section("title", "Edit Event")
@section("title-page", "Edit Data Event")
@push("styles")
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush
@section("body")
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="nama_event" class="col-sm-2 col-form-label">Nama Event <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_event" name="nama_event" value="{{ old('nama_event', $event->nama_event) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tanggal_event" class="col-sm-2 col-form-label">Tanggal Event <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="tanggal_event" name="tanggal_event" value="{{ old('tanggal_event', $event->tanggal_event) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="waktu_event" class="col-sm-2 col-form-label">Waktu Event <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="time" class="form-control" id="waktu_event" name="waktu_event" value="{{ old('waktu_event', $event->waktu_event) }}" step="60">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="poster" class="col-sm-2 col-form-label">Poster/Thumbnail <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="poster" name="poster">
                            </div>
                        </div>
                        
                        @if ($event->thumbnail)
                            <div class="row mb-3">
                                <label for="poster" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img src="{{ asset($event->thumbnail) }}" class="img-thumbnail" alt="Poster Event" style="max-width: 200px; height: auto;">
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <label for="deskripsi_event" class="col-sm-2 col-form-label">Deskripsi Event <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div id="editor" style="height: 200px;"></div>
                                <textarea class="form-control d-none" id="deskripsi_event" name="deskripsi_event" rows="3">{{ old('deskripsi_event', $event->deskripsi_event) }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Pilih kategori...',
                allowClear: true,
                closeOnSelect: false,
                language: {
                    noResults: function() {
                        return "Tidak ada hasil ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    },
                    removeAllItems: function() {
                        return "Hapus semua item";
                    }
                }
            });
        });
    </script>
    <script type="text/javascript">
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'],
                    ['link'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'header': [1, 2, 3, false] }],
                ]
            }
        });

        quill.root.innerHTML = document.getElementById('deskripsi_event').value;

        quill.on('text-change', function() {
            document.getElementById('deskripsi_event').value = quill.root.innerHTML;
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            document.getElementById('deskripsi_event').value = quill.root.innerHTML;
        });
    </script>
@endpush
