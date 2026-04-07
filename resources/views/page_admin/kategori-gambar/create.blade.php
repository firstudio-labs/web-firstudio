@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kategori Gambar /</span> Tambah Kategori Gambar</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Tambah Kategori Gambar</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.kategori-gambar.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="kategori_gambar" class="form-label">Kategori Gambar</label>
                                <input type="text" class="form-control @error('kategori_gambar') is-invalid @enderror"
                                    id="kategori_gambar" name="kategori_gambar" value="{{ old('kategori_gambar') }}"
                                    placeholder="Masukkan kategori gambar">
                                @error('kategori_gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                    name="deskripsi" rows="3"
                                    placeholder="Masukkan deskripsi">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save"></i> Simpan
                                </button>
                                <a href="{{ route('admin.kategori-gambar.index') }}" class="btn btn-secondary">
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
