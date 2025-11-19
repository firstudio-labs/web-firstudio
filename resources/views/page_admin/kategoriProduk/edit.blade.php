@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kategori Produk /</span> Edit Kategori Produk</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Edit Kategori Produk</h5>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.kategoriProduk.update', $kategoriProduk->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kategori_produk">Kategori Produk</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('kategori_produk') is-invalid @enderror"
                                        id="kategori_produk" name="kategori_produk"
                                        value="{{ old('kategori_produk', $kategoriProduk->kategori_produk) }}"
                                        placeholder="Masukkan kategori produk" />
                                    @error('kategori_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="deskripsi">Deskripsi</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                        name="deskripsi" rows="5"
                                        placeholder="Masukkan deskripsi kategori">{{ old('deskripsi', $kategoriProduk->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ route('admin.kategoriProduk.index') }}" class="btn btn-secondary">
                                        <i class="bx bx-x"></i> Batal
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection