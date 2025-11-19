@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Produk /</span> Detail Produk</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Produk</h5>
                        <div>
                            <a href="{{ route('admin.produk.edit', $produk->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/produk/' . $produk->gambar) }}" alt="{{ $produk->judul }}"
                                    class="img-fluid rounded" style="max-width: 100%; height: auto;">
                            </div>
                            <div class="col-md-8">
                                <table class="table">
                                    <tr>
                                        <th style="width: 200px;">Judul Produk</th>
                                        <td>{{ $produk->judul }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td>{{ $produk->kategoriProduk->kategori_produk ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug</th>
                                        <td>{{ $produk->slug }}</td>
                                    </tr>
                                    <tr>
                                        <th>Link Project</th>
                                        <td>
                                            @if($produk->link)
                                                <a href="{{ $produk->link }}" target="_blank" rel="noopener">
                                                    {{ $produk->link }}
                                                </a>
                                            @else
                                                <span class="text-muted">Tidak tersedia</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td><div class="content-display">{!! $produk->deskripsi !!}</div></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Dibuat</th>
                                        <td>{{ $produk->created_at->format('d F Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir Diperbarui</th>
                                        <td>{{ $produk->updated_at->format('d F Y H:i') }}</td>
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