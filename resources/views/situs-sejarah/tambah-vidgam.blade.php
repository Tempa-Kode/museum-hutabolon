@extends("template")
@section("title", "Tambah Data Video/Gambar")
@section("title-page", "Tambah Data Video/Gambar {$data->nama}")
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
            <div class="alert alert-success">
                {{ session('error') }}
            </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('situs-sejarah.simpan-vidgam', $data->slug) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row mb-3">
                            <label for="jenis" class="col-sm-2 form-label">Jenis Media <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-select" id="jenis" name="jenis" required>
                                    <option value="">Pilih Jenis Media</option>
                                    <option value="gambar">Gambar</option>
                                    <option value="vidio">Video YouTube</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3" id="upload-gambar" style="display: none;">
                            <label for="gambar" class="col-sm-2 form-label">Upload Gambar <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                <div class="form-text">Format yang didukung: JPG, JPEG, PNG. Maksimal 5MB.</div>
                                <div class="image-preview mt-3" id="image-preview" style="display: none;">
                                    <div class="text-center p-3 rounded bg-light">
                                        <img src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3" id="link-video" style="display: none;">
                            <label for="video_url" class="col-sm-2 form-label">Link Video YouTube <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="url" class="form-control" id="video_url" name="video_url"
                                    placeholder="https://www.youtube.com/watch?v=...">
                                <div class="form-text">Masukkan link YouTube yang valid.</div>
                                <div class="video-preview mt-3" id="video-preview" style="display: none;">
                                    <div class="ratio ratio-16x9">
                                        <iframe src="" title="Video Preview" frameborder="0" allowfullscreen
                                            class="rounded border"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-10">
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
                } else if (selectedType === 'vidio') {
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
@endpush
