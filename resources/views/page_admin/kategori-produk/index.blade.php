@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kategori Produk /</span> Data Kategori Produk</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Kategori Produk</h5>
                        <a href="{{ route('admin.kategori-produk.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Tambah Kategori
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori Produk</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kategori_produks as $index => $kategori_produk)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $kategori_produk->kategori_produk }}</td>
                                            <td>{{ $kategori_produk->deskripsi }}</td>
                                            <td>
                                                <div class="d-flex gap-2">

                                                    <a href="{{ route('admin.kategori-produk.edit', $kategori_produk->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.kategori-produk.destroy', $kategori_produk->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="bx bx-category mb-2" style="font-size: 3rem;"></i>
                                                    <h5>Belum ada data kategori produk</h5>
                                                    <p class="text-muted">Silakan tambahkan data kategori produk terlebih dahulu
                                                    </p>
                                                    <a href="{{ route('admin.kategori-produk.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus"></i> Tambah Kategori
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection