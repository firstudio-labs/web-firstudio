@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tentang /</span> Detail Tentang</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Tentang</h5>
                        <div>
                            <a href="{{ route('admin.tentang.edit', $tentang->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.tentang.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">Gambar</h6>
                                @if ($tentang->gambar)
                                    <img src="{{ asset('storage/tentang/' . $tentang->gambar) }}"
                                        alt="Gambar {{ $tentang->judul }}" class="img-fluid rounded" style="max-height: 300px;">
                                @else
                                    <div class="bg-light rounded p-4 text-center">
                                        <i class="bx bx-image" style="font-size: 3rem;"></i>
                                        <p class="mt-2 mb-0">Tidak ada gambar</p>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">Judul</h6>
                                <p>{{ $tentang->judul }}</p>

                                <h6 class="fw-bold mt-4">Deskripsi</h6>
                                <div class="content-display bg-light border rounded p-3">
                                    {!! $tentang->deskripsi !!}
                                </div>

                                <h6 class="fw-bold mt-4">Hitungan</h6>
                                <p>
                                    @if(is_array($tentang->hitungan))
                                        {{ implode(', ', $tentang->hitungan) }}
                                    @else
                                        {{ $tentang->hitungan }}
                                    @endif
                                </p>

                                <h6 class="fw-bold mt-4">Keterangan Hitungan</h6>
                                <p>
                                    @if(is_array($tentang->keterangan_hitungan))
                                        {{ implode(', ', $tentang->keterangan_hitungan) }}
                                    @else
                                        {{ $tentang->keterangan_hitungan }}
                                    @endif
                                </p>
                            </div>

                            <div class="col-md-12 mb-4">
                                <h6 class="fw-bold">Keterangan Memilih</h6>
                                <div class="content-display bg-light border rounded p-3">
                                    {!! $tentang->keterangan_memilih !!}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">Gambar Nilai</h6>
                                @if ($tentang->gambar_nilai)
                                    <img src="{{ asset('storage/tentang/' . $tentang->gambar_nilai) }}" alt="Gambar Nilai"
                                        class="img-fluid rounded" style="max-height: 300px;">
                                @else
                                    <div class="bg-light rounded p-4 text-center">
                                        <i class="bx bx-image" style="font-size: 3rem;"></i>
                                        <p class="mt-2 mb-0">Tidak ada gambar nilai</p>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 mb-4">
                                <h6 class="fw-bold">Keterangan Nilai</h6>
                                <div class="content-display bg-light border rounded p-3">
                                    {!! $tentang->keterangan_nilai !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
