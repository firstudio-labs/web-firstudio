@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-2"><span class="text-muted fw-light">Artikel /</span> Data Artikel</h4>
        @auth
        <div class="mb-3">
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <div>
                    <i class="bx bx-bolt me-1"></i>
                    Token AI hari ini: <strong>{{ $aiDailyLimit - $aiRemainingTokens }}/{{ $aiDailyLimit }}</strong> terpakai
                    | Sisa: <strong>{{ $aiRemainingTokens }}</strong>
                </div>
                <span class="badge bg-{{ $aiRemainingTokens > 0 ? 'success' : 'secondary' }}">{{ $aiRemainingTokens }} tersisa</span>
            </div>
        </div>
        @endauth

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Artikel</h5>
                        <div class="d-flex gap-2">
                            <form action="{{ route('admin.artikel.index') }}" method="GET" class="d-flex">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari judul artikel..." name="filter" value="{{ $filter ?? '' }}">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="bx bx-search"></i>
                                    </button>
                                    @if(isset($filter) && $filter)
                                    <a href="{{ route('admin.artikel.index') }}" class="btn btn-outline-secondary">
                                        <i class="bx bx-x"></i>
                                    </a>
                                    @endif
                                </div>
                            </form>
                            <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus"></i> Tambah Artikel
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
                                        <th>Judul</th>
                                        <th>Penulis</th>
                                        <th>Kategori</th>
                                        <th>Isi</th>
                                        <th>Catatan</th>
                                        <th>Komentar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($artikels as $index => $artikel)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if ($artikel->gambar)
                                                    <img src="{{ asset('storage/artikel/' . $artikel->gambar) }}"
                                                        alt="Gambar {{ $artikel->judul }}" class="img-thumbnail"
                                                        style="max-height: 100px;">
                                                @else
                                                    <div class="bg-light rounded p-2">
                                                        <i class="bx bx-user" style="font-size: 2rem;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $artikel->judul }}</td>
                                            <td>{{ $artikel->penulis }}</td>
                                            <td>{{ $artikel->kategoriArtikel->kategori_artikel }}</td>
                                            <td>{!! Str::limit($artikel->isi, 50) !!}</td>
                                            <td>{{ $artikel->catatan }}</td>
                                            <td>{{ $artikel->komentar }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $artikel->status == 'Publik' ? 'success' : 'danger' }}">
                                                    {{ $artikel->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.artikel.show', $artikel->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('admin.artikel.edit', $artikel->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST"
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
                                                    <i class="bx bx-user mb-2" style="font-size: 3rem;"></i>
                                                    <h5>Belum ada data artikel</h5>
                                                    <p class="text-muted">Silakan tambahkan data artikel terlebih dahulu</p>
                                                    <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus"></i> Tambah Artikel
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-4 d-flex justify-content-center">
                            {{ $artikels->appends(['filter' => $filter ?? ''])->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection