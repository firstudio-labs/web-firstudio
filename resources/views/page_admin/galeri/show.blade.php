@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Galeri /</span> Detail Galeri</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Detail Galeri</h5>
                        <div>
                            <a href="{{ route('admin.galeri.edit', $galeri->id) }}" class="btn btn-warning">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Keterangan</label>
                                    <p class="form-control-plaintext">{{ $galeri->keterangan }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Kategori Gambar</label>
                                    <p class="form-control-plaintext">{{ $galeri->kategoriGambar->kategori_gambar ?? '-' }}
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Slug</label>
                                    <p class="form-control-plaintext">{{ $galeri->slug }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tanggal Dibuat</label>
                                    <p class="form-control-plaintext">{{ $galeri->created_at->format('d F Y H:i') }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Terakhir Diperbarui</label>
                                    <p class="form-control-plaintext">{{ $galeri->updated_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Gambar</label>
                                    @if ($galeri->gambar)
                                        <div class="text-center">
                                            <img src="{{ asset('storage/galeri/' . $galeri->gambar) }}"
                                                alt="Gambar {{ $galeri->keterangan }}" class="img-fluid rounded"
                                                style="max-height: 400px;">
                                        </div>
                                    @else
                                        <div class="bg-light rounded p-4 text-center">
                                            <i class="bx bx-image" style="font-size: 4rem; color: #ccc;"></i>
                                            <p class="text-muted mt-2">Tidak ada gambar</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection