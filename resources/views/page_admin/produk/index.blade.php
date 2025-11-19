@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Produk /</span> Data Produk</h4>
        
        @auth
        <div class="mb-3">
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <div>
                    <i class="bx bx-bolt me-1"></i>
                    Token AI hari ini: <strong>{{ $aiDailyLimit - $aiRemainingTokens }}/{{ $aiDailyLimit }}</strong> terpakai
                    | Sisa: <strong id="aiRemainingTokens">{{ $aiRemainingTokens }}</strong>
                </div>
                <span class="badge bg-{{ $aiRemainingTokens > 0 ? 'success' : 'secondary' }}">{{ $aiRemainingTokens }} tersisa</span>
            </div>
        </div>
        @endauth

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Produk</h5>
                        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Tambah Produk
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
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Deskripsi</th>
                                        <th>Link</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produks as $index => $produk)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <img src="{{ asset('storage/produk/' . $produk->gambar) }}"
                                                    alt="{{ $produk->judul }}" class="img-thumbnail"
                                                    style="max-width: 100px; height: auto;">
                                            </td>
                                            <td>{{ $produk->judul }}</td>
                                            <td>{{ $produk->kategoriProduk->kategori_produk ?? '-' }}</td>
                                            <td>{!! Str::limit($produk->deskripsi, 50) !!}</td>
                                            <td>
                                                @if($produk->link)
                                                    <a href="{{ $produk->link }}" target="_blank" rel="noopener" class="badge bg-label-primary">
                                                        Kunjungi
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.produk.show', $produk->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('admin.produk.edit', $produk->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST"
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
                                                    <i class="bx bx-package mb-2" style="font-size: 3rem;"></i>
                                                    <h5>Belum ada data produk</h5>
                                                    <p class="text-muted">Silakan tambahkan data produk terlebih dahulu</p>
                                                    <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus"></i> Tambah Produk
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $produks->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection