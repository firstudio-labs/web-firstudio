@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Layanan /</span> Katalog Template</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Template Website</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.kategoriTemplate.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-category"></i> Kelola Kategori
                            </a>
                            <a href="{{ route('admin.template.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus"></i> Tambah Template
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Gambar</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Pemilih</th>
                                        <th>Link</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($templates as $index => $template)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <img src="{{ asset('storage/template/' . $template->gambar) }}"
                                                    alt="{{ $template->judul }}" class="rounded"
                                                    style="width: 80px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <span class="fw-semibold text-primary">{{ $template->judul }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-label-info">{{ $template->kategori->nama_kategori }}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $template->jumlah_pemilih }}</span>
                                            </td>
                                            <td>
                                                @if($template->link)
                                                    <a href="{{ $template->link }}" target="_blank" class="btn btn-xs btn-outline-primary">Preview</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('admin.template.edit', $template->id) }}">
                                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                                        </a>
                                                        <form action="{{ route('admin.template.destroy', $template->id) }}" method="POST" onsubmit="return confirm('Hapus template ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bx bx-trash me-1"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Belum ada template.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $templates->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
