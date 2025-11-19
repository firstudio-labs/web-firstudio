@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Artikel /</span> Detail Artikel</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Detail Artikel</h5>
                        <div>
                            <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="btn btn-warning">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                            @if($artikel->gambar)
                                    <div class="card mb-3">
                                        <img src="{{ asset('storage/artikel/' . $artikel->gambar) }}" class="card-img-top"
                                            alt="Gambar Berita" style="max-height: 500px;">
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        Tidak ada gambar untuk artikel ini
                                    </div>
                                @endif
                                <h1 class="mb-3 fw-bold" style="font-size: 24px;">{{ $artikel->judul }}</h1>
                                <p class="text-muted mb-3">
                                    <i class="bx bx-user"></i> {{ $artikel->penulis }}
                                    <i class="bx bx-category"></i> {{ $artikel->kategoriArtikel->kategori_artikel }}
                                </p>
                                <div class="mb-3">
                                    <span class="badge bg-{{ $artikel->status == 'Publik' ? 'success' : 'warning' }}">
                                        {{ $artikel->status }}
                                    </span>
                                    <small class="text-muted ms-2">
                                        Dibuat pada: {{ $artikel->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>

                                <div class="mb-4">
                                    <div class="content-display">
                                        {!! $artikel->isi !!}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <h2 class="mb-3">Komentar</h2>
                                    @forelse($artikel->komentarArtikel as $komentar)
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="row g-2 align-items-center">
                                                    <div class="col-md-4">
                                                        <label class="form-label"><i class="bx bx-user"></i> Nama</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $komentar->nama_komentar }}" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label"><i class="bx bx-phone"></i> No HP</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $komentar->no_hp_komentar }}" readonly>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label"><i class="bx bx-envelope"></i> Email</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $komentar->email_komentar }}" readonly>
                                                    </div>
                                                    <div class="col-12 mt-2">
                                                        <label class="form-label"><i class="bx bx-message"></i> Komentar</label>
                                                        <textarea class="form-control" rows="3"
                                                            readonly>{{ $komentar->komentar }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info">
                                            Belum ada komentar untuk artikel ini
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
