@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Kontak /</span> Detail Kontak
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Kontak</h5>
                        <div>
                            <a href="{{ route('admin.kontak.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                            <a href="{{ route('admin.kontak.edit', $kontak->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Nama</div>
                            <div class="col-md-9">: {{ $kontak->nama }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Email</div>
                            <div class="col-md-9">: {{ $kontak->email }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">No. HP</div>
                            <div class="col-md-9">: {{ $kontak->no_hp }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Pesan</div>
                            <div class="col-md-9">: {{ $kontak->pesan }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Tanggal Dibuat</div>
                            <div class="col-md-9">: {{ $kontak->created_at->format('d F Y H:i') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 fw-bold">Terakhir Diperbarui</div>
                            <div class="col-md-9">: {{ $kontak->updated_at->format('d F Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection