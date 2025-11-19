@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Beranda /</span> Edit Beranda</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Beranda</h5>
                        <a href="{{ route('admin.beranda.index') }}" class="btn btn-secondary">
                            <i class="bx bx-arrow-back"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.beranda.update', $beranda->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="judul_utama" class="form-label">Judul Utama</label>
                                        <input type="text" class="form-control @error('judul_utama') is-invalid @enderror"
                                            id="judul_utama" name="judul_utama"
                                            value="{{ old('judul_utama', $beranda->judul_utama) }}">
                                        @error('judul_utama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="judul_sekunder" class="form-label">Judul Sekunder</label>
                                        <input type="text"
                                            class="form-control @error('judul_sekunder') is-invalid @enderror"
                                            id="judul_sekunder" name="judul_sekunder"
                                            value="{{ old('judul_sekunder', $beranda->judul_sekunder) }}">
                                        @error('judul_sekunder')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="slogan" class="form-label">Slogan</label>
                                <input type="text" class="form-control @error('slogan') is-invalid @enderror" id="slogan"
                                    name="slogan" value="{{ old('slogan', $beranda->slogan) }}">
                                @error('slogan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gambar_utama" class="form-label">Gambar Utama</label>
                                        <input type="file" class="form-control @error('gambar_utama') is-invalid @enderror"
                                            id="gambar_utama" name="gambar_utama">
                                        @error('gambar_utama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($beranda->gambar_utama)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/beranda/' . $beranda->gambar_utama) }}"
                                                    alt="Gambar Utama" class="img-thumbnail" style="max-height: 200px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gambar_sekunder" class="form-label">Gambar Sekunder</label>
                                        <input type="file"
                                            class="form-control @error('gambar_sekunder') is-invalid @enderror"
                                            id="gambar_sekunder" name="gambar_sekunder">
                                        @error('gambar_sekunder')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($beranda->gambar_sekunder)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/beranda/' . $beranda->gambar_sekunder) }}"
                                                    alt="Gambar Sekunder" class="img-thumbnail" style="max-height: 200px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                    name="keterangan" rows="4">{{ old('keterangan', $beranda->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection