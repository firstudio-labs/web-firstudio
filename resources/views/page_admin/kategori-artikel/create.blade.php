@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kategori Artikel /</span> Tambah Kategori</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Form Tambah Kategori Artikel</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.kategori-artikel.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kategori_artikel" class="form-label">Kategori Artikel</label>
                                        <input type="text" class="form-control @error('kategori_artikel') is-invalid @enderror"
                                            id="kategori_artikel" name="kategori_artikel" value="{{ old('kategori_artikel') }}" required>
                                        @error('kategori_artikel')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save"></i> Simpan
                                </button>
                                <a href="{{ route('admin.kategori-artikel.index') }}" class="btn btn-secondary">
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