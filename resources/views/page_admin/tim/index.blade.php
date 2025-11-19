@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tim /</span> Data Tim</h4>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Tim</h5>
                        <a href="{{ route('admin.tim.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Tambah Tim
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
                                        <th>Posisi</th>
                                        <th>Quote</th>
                                        <th>Sosial Media</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tim as $index => $t)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if ($t->gambar)
                                                    <img src="{{ asset('storage/tim/' . $t->gambar) }}" alt="Gambar {{ $t->nama }}"
                                                        class="img-thumbnail" style="max-height: 100px; width: auto;">
                                                @else
                                                    <div class="bg-light rounded p-2">
                                                        <i class="bx bx-user" style="font-size: 2rem;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $t->nama }}</td>
                                            <td>{{ $t->posisi }}</td>
                                            <td>{!! Str::limit($t->quote, 50) !!}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ $t->instagram }}" target="_blank" class="btn btn-sm btn-danger">
                                                        <i class="bx bxl-instagram"></i>
                                                    </a>
                                                    <a href="{{ $t->linkedin }}" target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="bx bxl-linkedin"></i>
                                                    </a>
                                                    <a href="{{ $t->facebook }}" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="bx bxl-facebook"></i>
                                                    </a>
                                                    <a href="https://wa.me/{{ $t->whatsapp }}" target="_blank"
                                                        class="btn btn-sm btn-success">
                                                        <i class="bx bxl-whatsapp"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.tim.show', $t->id) }}" class="btn btn-sm btn-info">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('admin.tim.edit', $t->id) }}" class="btn btn-sm btn-primary">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.tim.destroy', $t->id) }}" method="POST"
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
                                                    <h5>Belum ada data tim</h5>
                                                    <p class="text-muted">Silakan tambahkan data tim terlebih dahulu</p>
                                                    <a href="{{ route('admin.tim.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus"></i> Tambah Tim
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