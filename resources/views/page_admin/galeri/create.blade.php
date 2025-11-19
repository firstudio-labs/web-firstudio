@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Galeri /</span> Tambah Galeri</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Form Tambah Galeri</h5>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                            id="keterangan" name="keterangan" value="{{ old('keterangan') }}" required>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="kategori_gambar_id" class="form-label">Kategori Gambar</label>
                                        <select class="form-select @error('kategori_gambar_id') is-invalid @enderror"
                                            id="kategori_gambar_id" name="kategori_gambar_id" required>
                                            <option value="">Pilih Kategori Gambar</option>
                                            @foreach ($kategoriGambars as $kategoriGambar)
                                                <option value="{{ $kategoriGambar->id }}" {{ old('kategori_gambar_id') == $kategoriGambar->id ? 'selected' : '' }}>
                                                    {{ $kategoriGambar->kategori_gambar }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori_gambar_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="gambar" class="form-label">Gambar</label>
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                            id="gambar" name="gambar" accept="image/*" required>
                                        <small class="text-muted">Format: jpeg, png, jpg, gif, svg. Maksimal 2MB</small>
                                        @error('gambar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save"></i> Simpan
                                </button>
                                <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">
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