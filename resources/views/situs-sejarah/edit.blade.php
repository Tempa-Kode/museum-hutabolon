@extends("template")
@section("title", "Data Situs Sejarah")
@section("title-page", "Edit Data Situs Sejarah")
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
                    <form action="{{ route('situs-sejarah.update', $situsSejarah->slug) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="nama" class="col-sm-2 col-form-label">Nama Situs Sejarah <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $situsSejarah->nama) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="kategori_id" class="col-sm-2 col-form-label">Kategori <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select js-example-basic-multiple" name="kategori_id[]" id="kategori_id" multiple="multiple">
                                    @foreach($kategori as $item)
                                        <option value="{{ $item->id }}" {{ in_array($item->id, old('kategori_id', $situsSejarah->kategori->pluck('id')->toArray())) ? 'selected' : '' }}>
                                            {{ $item->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="lokasi" class="col-sm-2 col-form-label">Lokasi <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ old('lokasi', $situsSejarah->lokasi) }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="deskripsi_konten" class="col-sm-2 col-form-label">Deskripsi Konten</label>
                            <div class="col-sm-10">
                                <div id="editor" style="height: 200px;"></div>
                                <textarea class="form-control d-none" id="deskripsi_konten" name="deskripsi_konten" rows="3">{{ old('deskripsi_konten', $situsSejarah->deskripsi_konten) }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">Edit</button>
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

        quill.root.innerHTML = document.getElementById('deskripsi_konten').value;

        quill.on('text-change', function() {
            document.getElementById('deskripsi_konten').value = quill.root.innerHTML;
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            document.getElementById('deskripsi_konten').value = quill.root.innerHTML;
        });
    </script>
@endpush
