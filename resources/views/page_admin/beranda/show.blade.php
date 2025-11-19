@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Beranda /</span> Detail Beranda</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Beranda</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.beranda.edit', $beranda->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.beranda.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="fw-bold">Gambar Utama</h6>
                                    @if ($beranda->gambar_utama)
                                        <img src="{{ asset('storage/beranda/' . $beranda->gambar_utama) }}" alt="Gambar Utama"
                                            class="img-fluid rounded" style="max-height: 300px;">
                                    @else
                                        <div class="bg-light rounded p-4 text-center">
                                            <i class="bx bx-image" style="font-size: 3rem;"></i>
                                            <p class="mt-2 mb-0">Tidak ada gambar</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h6 class="fw-bold">Gambar Sekunder</h6>
                                    @if ($beranda->gambar_sekunder)
                                        <img src="{{ asset('storage/beranda/' . $beranda->gambar_sekunder) }}"
                                            alt="Gambar Sekunder" class="img-fluid rounded" style="max-height: 300px;">
                                    @else
                                        <div class="bg-light rounded p-4 text-center">
                                            <i class="bx bx-image" style="font-size: 3rem;"></i>
                                            <p class="mt-2 mb-0">Tidak ada gambar</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="fw-bold">Judul Utama</h6>
                                    <p class="mb-0">{{ $beranda->judul_utama }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="fw-bold">Judul Sekunder</h6>
                                    <p class="mb-0">{{ $beranda->judul_sekunder }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <h6 class="fw-bold">Slogan</h6>
                                    <p class="mb-0">{{ $beranda->slogan }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <h6 class="fw-bold">Keterangan</h6>
                                    <p class="mb-0">{!! $beranda->keterangan !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection