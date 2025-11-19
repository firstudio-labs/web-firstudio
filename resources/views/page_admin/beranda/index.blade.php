@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Beranda /</span> Data Beranda</h4>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Beranda</h5>
                        <a href="{{ route('admin.beranda.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Tambah Beranda
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
                                        <th>Gambar Utama</th>
                                        <th>Judul Utama</th>
                                        <th>Slogan</th>
                                        <th>Gambar Sekunder</th>
                                        <th>Judul Sekunder</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($berandas as $index => $beranda)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if ($beranda->gambar_utama)
                                                    <img src="{{ asset('storage/beranda/' . $beranda->gambar_utama) }}"
                                                        alt="Gambar Utama" class="img-thumbnail" style="max-height: 100px;">
                                                @else
                                                    <div class="bg-light rounded p-2">
                                                        <i class="bx bx-image" style="font-size: 2rem;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $beranda->judul_utama }}</td>
                                            <td>{{ $beranda->slogan }}</td>
                                            <td>
                                                @if ($beranda->gambar_sekunder)
                                                    <img src="{{ asset('storage/beranda/' . $beranda->gambar_sekunder) }}"
                                                        alt="Gambar Sekunder" class="img-thumbnail" style="max-height: 100px;">
                                                @else
                                                    <div class="bg-light rounded p-2">
                                                        <i class="bx bx-image" style="font-size: 2rem;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $beranda->judul_sekunder }}</td>
                                            <td>{!! Str::limit($beranda->keterangan, 50) !!}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.beranda.show', $beranda->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('admin.beranda.edit', $beranda->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.beranda.destroy', $beranda->id) }}" method="POST"
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
                                            <td colspan="8" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="bx bx-image mb-2" style="font-size: 3rem;"></i>
                                                    <h5>Belum ada data beranda</h5>
                                                    <p class="text-muted">Silakan tambahkan data beranda terlebih dahulu</p>
                                                    <a href="{{ route('admin.beranda.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus"></i> Tambah Beranda
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