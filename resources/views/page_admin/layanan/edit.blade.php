@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Layanan /</span> Edit Layanan</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Form Edit Layanan</h5>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.layanan.update', $layanan->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label" for="judul">Judul Layanan</label>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                            id="judul" name="judul" placeholder="Masukkan judul layanan"
                                            value="{{ old('judul', $layanan->judul) }}" />
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="deskripsi">Deskripsi Layanan</label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                            id="deskripsi" name="deskripsi" rows="5"
                                            placeholder="Masukkan deskripsi layanan">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="gambar">Gambar Layanan</label>
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                            id="gambar" name="gambar" accept="image/*" />
                                        @error('gambar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="mt-2">
                                            <div id="preview-container">
                                                @if($layanan->gambar)
                                                    <img src="{{ asset('storage/layanan/' . $layanan->gambar) }}"
                                                        alt="Gambar {{ $layanan->judul }}" class="img-thumbnail preview-image"
                                                        style="max-height: 200px;">
                                                @else
                                                    <div class="bg-light rounded p-4 text-center">
                                                        <i class="bx bx-image" style="font-size: 3rem;"></i>
                                                        <p class="mt-2 mb-0">Tidak ada gambar</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bx bx-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary">
                                    <i class="bx bx-x"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        // Konfigurasi CKEditor dengan toolbar lengkap
        const editorConfig = {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'link', 'insertTable', '|',
                    'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ]
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                ]
            },
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            }
        };

        // Inisialisasi CKEditor untuk deskripsi
        let editorDeskripsi;
        ClassicEditor
            .create(document.querySelector('#deskripsi'), editorConfig)
            .then(newEditor => {
                editorDeskripsi = newEditor;
            })
            .catch(error => {
                console.error(error);
            });

        // Preview gambar sebelum upload
        document.getElementById('gambar').addEventListener('change', function (e) {
            const previewContainer = document.getElementById('preview-container');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    // Hapus konten sebelumnya
                    previewContainer.innerHTML = '';

                    // Buat elemen gambar baru
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview gambar';
                    img.className = 'img-thumbnail preview-image';
                    img.style.maxHeight = '200px';

                    // Tambahkan gambar ke container
                    previewContainer.appendChild(img);
                }

                reader.readAsDataURL(file);
            } else {
                // Jika tidak ada file yang dipilih, tampilkan placeholder
                previewContainer.innerHTML = `
                        <div class="bg-light rounded p-4 text-center">
                            <i class="bx bx-image" style="font-size: 3rem;"></i>
                            <p class="mt-2 mb-0">Tidak ada gambar</p>
                        </div>
                    `;
            }
        });
    </script>
@endsection