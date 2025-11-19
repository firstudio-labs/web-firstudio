@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Layanan /</span> Detail Layanan</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Layanan</h5>
                        <div>
                            <a href="{{ route('admin.layanan.edit', $layanan->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <h6 class="fw-bold">Judul Layanan</h6>
                                    <p>{{ $layanan->judul }}</p>
                                </div>

                                <div class="mb-3">
                                    <h6 class="fw-bold">Deskripsi Layanan</h6>
                                    <div class="content-display">{!! $layanan->deskripsi !!}</div>
                                </div>

                                <div class="mb-3">
                                    <h6 class="fw-bold">Informasi</h6>
                                    <div class="d-flex gap-4">
                                        <div>
                                            <small class="text-muted d-block">Dibuat pada</small>
                                            <span>{{ $layanan->created_at->format('d F Y H:i') }}</span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Terakhir diupdate</small>
                                            <span>{{ $layanan->updated_at->format('d F Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <h6 class="fw-bold">Gambar Layanan</h6>
                                    @if($layanan->gambar)
                                        <img src="{{ asset('storage/layanan/' . $layanan->gambar) }}"
                                            alt="Gambar {{ $layanan->judul }}" class="img-fluid rounded">
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
            </div>
        </div>
    </div>
@endsection