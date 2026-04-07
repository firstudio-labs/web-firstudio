@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Layanan / Katalog Template /</span> Tambah Template</h4>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tambah Template Baru</h5>
                        <small class="text-muted float-end">Website Design</small>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-3">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.template.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="judul">Judul Template</label>
                                <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Agrikultur Modern" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kategori_template_id">Kategori</label>
                                <select class="form-select" id="kategori_template_id" name="kategori_template_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('kategori_template_id') == $category->id ? 'selected' : '' }}>{{ $category->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <textarea id="deskripsi" name="deskripsi" class="form-control" placeholder="Jelaskan tentang template ini..." rows="4" required>{{ old('deskripsi') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="gambar">Gambar (Upload Foto)</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required />
                                <div class="form-text">Format: JPG, PNG, WEBP. Max: 7MB.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="link">Link Preview (Opsional)</label>
                                <input type="url" class="form-control" id="link" name="link" value="{{ old('link') }}" placeholder="https://..." />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jumlah_pemilih">Jumlah Pemilih Awal</label>
                                <input type="number" class="form-control" id="jumlah_pemilih" name="jumlah_pemilih" value="{{ old('jumlah_pemilih', 0) }}" />
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Simpan Template</button>
                            <a href="{{ route('admin.template.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
