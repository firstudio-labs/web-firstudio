@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kategori Gambar /</span> Detail Kategori Gambar</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Kategori Gambar</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.kategori-gambar.edit', $kategori_gambar->id) }}" class="btn btn-warning">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.kategori-gambar.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 200px;">Kategori Gambar</th>
                                        <td>{{ $kategori_gambar->kategori_gambar }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug</th>
                                        <td>{{ $kategori_gambar->slug }}</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $kategori_gambar->deskripsi ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Pada</th>
                                        <td>{{ $kategori_gambar->created_at->format('d F Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Diperbarui Pada</th>
                                        <td>{{ $kategori_gambar->updated_at->format('d F Y H:i') }}</td>
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







