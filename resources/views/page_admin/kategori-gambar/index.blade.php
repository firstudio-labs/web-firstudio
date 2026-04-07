@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kategori Gambar /</span> Data Kategori Gambar</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Kategori Gambar</h5>
                        <a href="{{ route('admin.kategori-gambar.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Tambah Kategori Gambar
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
                                        <th>Kategori Gambar</th>
                                        <th>Slug</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kategori_gambars as $index => $kategori_gambar)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $kategori_gambar->kategori_gambar }}</td>
                                            <td>{{ $kategori_gambar->slug }}</td>
                                            <td>{{ Str::limit($kategori_gambar->deskripsi, 50) }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.kategori-gambar.show', $kategori_gambar->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('admin.kategori-gambar.edit', $kategori_gambar->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.kategori-gambar.destroy', $kategori_gambar->id) }}"
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
                                                    <i class="bx bx-image mb-2" style="font-size: 3rem;"></i>
                                                    <h5>Belum ada data kategori gambar</h5>
                                                    <p class="text-muted">Silakan tambahkan data kategori gambar terlebih dahulu
                                                    </p>
                                                    <a href="{{ route('admin.kategori-gambar.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus"></i> Tambah Kategori Gambar
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $kategori_gambars->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection







