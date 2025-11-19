@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tentang /</span> Edit Tentang</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Form Edit Tentang</h5>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.tentang.update', $tentang->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="gambar">Gambar</label>
                                    <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                        id="gambar" name="gambar" accept="image/*" />
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($tentang->gambar)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/tentang/' . $tentang->gambar) }}"
                                                alt="Gambar {{ $tentang->judul }}" class="img-thumbnail"
                                                style="max-height: 200px;">
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="judul">Judul</label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                                        name="judul" value="{{ old('judul', $tentang->judul) }}"
                                        placeholder="Masukkan judul" required />
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                        name="deskripsi" rows="6" placeholder="Masukkan deskripsi"
                                        required>{{ old('deskripsi', $tentang->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Hitungan (4 bidang angka)</label>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <input type="number"
                                                class="form-control @error('hitungan.0') is-invalid @enderror"
                                                name="hitungan[]"
                                                value="{{ old('hitungan.0', $tentang->hitungan[0] ?? '') }}"
                                                placeholder="Angka 1"  />
                                            @error('hitungan.0')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <input type="number"
                                                class="form-control @error('hitungan.1') is-invalid @enderror"
                                                name="hitungan[]"
                                                value="{{ old('hitungan.1', $tentang->hitungan[1] ?? '') }}"
                                                placeholder="Angka 2"  />
                                            @error('hitungan.1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <input type="number"
                                                class="form-control @error('hitungan.2') is-invalid @enderror"
                                                name="hitungan[]"
                                                value="{{ old('hitungan.2', $tentang->hitungan[2] ?? '') }}"
                                                placeholder="Angka 3"  />
                                            @error('hitungan.2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <input type="number"
                                                class="form-control @error('hitungan.3') is-invalid @enderror"
                                                name="hitungan[]"
                                                value="{{ old('hitungan.3', $tentang->hitungan[3] ?? '') }}"
                                                placeholder="Angka 4"  />
                                            @error('hitungan.3')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Keterangan Hitungan (4 keterangan)</label>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <input type="text"
                                                class="form-control @error('keterangan_hitungan.0') is-invalid @enderror"
                                                name="keterangan_hitungan[]"
                                                value="{{ old('keterangan_hitungan.0', $tentang->keterangan_hitungan[0] ?? '') }}"
                                                placeholder="Keterangan 1"  />
                                            @error('keterangan_hitungan.0')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <input type="text"
                                                class="form-control @error('keterangan_hitungan.1') is-invalid @enderror"
                                                name="keterangan_hitungan[]"
                                                value="{{ old('keterangan_hitungan.1', $tentang->keterangan_hitungan[1] ?? '') }}"
                                                placeholder="Keterangan 2"  />
                                            @error('keterangan_hitungan.1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <input type="text"
                                                class="form-control @error('keterangan_hitungan.2') is-invalid @enderror"
                                                name="keterangan_hitungan[]"
                                                value="{{ old('keterangan_hitungan.2', $tentang->keterangan_hitungan[2] ?? '') }}"
                                                placeholder="Keterangan 3"  />
                                            @error('keterangan_hitungan.2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <input type="text"
                                                class="form-control @error('keterangan_hitungan.3') is-invalid @enderror"
                                                name="keterangan_hitungan[]"
                                                value="{{ old('keterangan_hitungan.3', $tentang->keterangan_hitungan[3] ?? '') }}"
                                                placeholder="Keterangan 4"  />
                                            @error('keterangan_hitungan.3')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="keterangan_memilih">Keterangan Memilih</label>
                                    <textarea class="form-control @error('keterangan_memilih') is-invalid @enderror"
                                        id="keterangan_memilih" name="keterangan_memilih" rows="5"
                                        placeholder="Masukkan keterangan memilih"
                                        >{{ old('keterangan_memilih', $tentang->keterangan_memilih) }}</textarea>
                                    @error('keterangan_memilih')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="gambar_nilai">Gambar Nilai</label>
                                    <input type="file" class="form-control @error('gambar_nilai') is-invalid @enderror"
                                        id="gambar_nilai" name="gambar_nilai" accept="image/*" />
                                    @error('gambar_nilai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($tentang->gambar_nilai)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/tentang/' . $tentang->gambar_nilai) }}"
                                                alt="Gambar Nilai" class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="keterangan_nilai">Keterangan Nilai</label>
                                    <textarea class="form-control @error('keterangan_nilai') is-invalid @enderror"
                                        id="keterangan_nilai" name="keterangan_nilai" rows="5"
                                        placeholder="Masukkan keterangan nilai"
                                        >{{ old('keterangan_nilai', $tentang->keterangan_nilai) }}</textarea>
                                    @error('keterangan_nilai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <a href="{{ route('admin.tentang.index') }}" class="btn btn-outline-secondary">Kembali</a>
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
                    'blockQuote', '|',
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
                console.error('Error initializing CKEditor:', error);
            });

        // Juga untuk keterangan_memilih dan keterangan_nilai jika diperlukan
        let editorKeteranganMemilih;
        ClassicEditor
            .create(document.querySelector('#keterangan_memilih'), editorConfig)
            .then(newEditor => {
                editorKeteranganMemilih = newEditor;
            })
            .catch(error => {
                console.error('Error initializing CKEditor for keterangan_memilih:', error);
            });

        let editorKeteranganNilai;
        ClassicEditor
            .create(document.querySelector('#keterangan_nilai'), editorConfig)
            .then(newEditor => {
                editorKeteranganNilai = newEditor;
            })
            .catch(error => {
                console.error('Error initializing CKEditor for keterangan_nilai:', error);
            });
    </script>
@endsection
