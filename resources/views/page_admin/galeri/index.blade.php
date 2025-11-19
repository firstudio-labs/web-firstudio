@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Galeri /</span> Data Galeri</h4>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Galeri</h5>
                        <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Tambah Galeri
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
                                        <th>Gambar</th>
                                        <th>Keterangan</th>
                                        <th>Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($galeris as $index => $galeri)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if ($galeri->gambar)
                                                    <img src="{{ asset('storage/galeri/' . $galeri->gambar) }}"
                                                        alt="Gambar {{ $galeri->keterangan }}" class="img-thumbnail"
                                                        style="max-height: 100px;">
                                                @else
                                                    <div class="bg-light rounded p-2">
                                                        <i class="bx bx-image" style="font-size: 2rem;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $galeri->keterangan }}</td>
                                            <td>{{ $galeri->kategoriGambar->kategori_gambar ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.galeri.show', $galeri->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('admin.galeri.edit', $galeri->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.galeri.destroy', $galeri->id) }}" method="POST"
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
                                                    <h5>Belum ada data galeri</h5>
                                                    <p class="text-muted">Silakan tambahkan data galeri terlebih dahulu</p>
                                                    <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus"></i> Tambah Galeri
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $galeris->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection