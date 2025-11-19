@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Testimoni /</span> Data Testimoni</h4>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Testimoni</h5>
                        <a href="{{ route('admin.testimoni.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Tambah Testimoni
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
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Testimoni</th>
                                        <th>Rating</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($testimonis as $index => $testimoni)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if ($testimoni->gambar)
                                                    <img src="{{ asset('storage/testimoni/' . $testimoni->gambar) }}"
                                                        alt="Gambar {{ $testimoni->nama }}" class="img-thumbnail"
                                                        style="max-height: 100px;">
                                                @else
                                                    <div class="bg-light rounded p-2">
                                                        <i class="bx bx-user" style="font-size: 2rem;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $testimoni->nama }}</td>
                                            <td>{{ $testimoni->jabatan }}</td>
                                            <td>{!! Str::limit($testimoni->testimoni, 50) !!}</td>
                                            <td>{{ $testimoni->rating }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.testimoni.show', $testimoni->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('admin.testimoni.edit', $testimoni->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.testimoni.destroy', $testimoni->id) }}"
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
                                            <td colspan="7" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="bx bx-user mb-2" style="font-size: 3rem;"></i>
                                                    <h5>Belum ada data testimoni</h5>
                                                    <p class="text-muted">Silakan tambahkan data testimoni terlebih dahulu</p>
                                                    <a href="{{ route('admin.testimoni.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus"></i> Tambah Testimoni
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