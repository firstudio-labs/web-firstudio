@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tim /</span> Detail Tim</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Tim</h5>
                        <div>
                            <a href="{{ route('admin.tim.edit', $tim->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.tim.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if ($tim->gambar)
                                    <img src="{{ asset('storage/tim/' . $tim->gambar) }}" alt="Gambar {{ $tim->nama }}"
                                        class="img-fluid rounded mb-3">
                                @else
                                    <div class="bg-light rounded p-5 text-center mb-3">
                                        <i class="bx bx-user" style="font-size: 5rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <table class="table">
                                    <tr>
                                        <th style="width: 200px;">Nama</th>
                                        <td>{{ $tim->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Posisi</th>
                                        <td>{{ $tim->posisi }}</td>
                                    </tr>
                                    <tr>
                                        <th>Quote</th>
                                        <td>{{ $tim->quote }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sosial Media</th>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ $tim->instagram }}" target="_blank"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="bx bxl-instagram"></i> Instagram
                                                </a>
                                                <a href="{{ $tim->linkedin }}" target="_blank"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bx bxl-linkedin"></i> LinkedIn
                                                </a>
                                                <a href="{{ $tim->facebook }}" target="_blank" class="btn btn-sm btn-info">
                                                    <i class="bx bxl-facebook"></i> Facebook
                                                </a>
                                                <a href="https://wa.me/{{ $tim->whatsapp }}" target="_blank"
                                                    class="btn btn-sm btn-success">
                                                    <i class="bx bxl-whatsapp"></i> WhatsApp
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection