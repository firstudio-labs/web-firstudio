@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kontak /</span> Data Kontak</h4>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Kontak</h5>
                        <a href="{{ route('admin.kontak.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Tambah Kontak
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
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No. HP</th>
                                        <th>Pesan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kontaks as $index => $kontak)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $kontak->nama }}</td>
                                            <td>{{ $kontak->email }}</td>
                                            <td>{{ $kontak->no_hp }}</td>
                                            <td>{!! Str::limit($kontak->pesan, 50) !!}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $kontak->status == 'Dibaca' ? 'success' : 'warning' }}">
                                                    {{ $kontak->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.kontak.show', $kontak->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('admin.kontak.edit', $kontak->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.kontak.destroy', $kontak->id) }}" method="POST"
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
                                                    <i class="bx bx-message-square-dots mb-2" style="font-size: 3rem;"></i>
                                                    <h5>Belum ada data kontak</h5>
                                                    <p class="text-muted">Silakan tambahkan data kontak terlebih dahulu</p>
                                                    <a href="{{ route('admin.kontak.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus"></i> Tambah Kontak
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