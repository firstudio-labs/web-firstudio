@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tentang /</span> Data Tentang</h4>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Tentang</h5>
                        @if($tentang && $tentang->count() > 0)
                            <button class="btn btn-secondary" disabled title="Data profil sudah ada. Hanya bisa menginputkan 1 data profil.">
                                <i class="bx bx-plus"></i> Tambah Tentang (Disabled)
                            </button>
                        @else
                            <a href="{{ route('admin.tentang.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus"></i> Tambah Tentang
                            </a>
                        @endif
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
                                        <th>Deskripsi</th>
                                        <th>Hitungan</th>
                                        <th>Keterangan Hitungan</th>
                                        <th>Keterangan Memilih</th>
                                        <th>Gambar Nilai</th>
                                        <th>Keterangan Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($tentang && $tentang->count() > 0)
                                        @foreach ($tentang as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($item->gambar)
                                                        <img src="{{ asset('storage/tentang/' . $item->gambar) }}"
                                                            alt="Gambar {{ $item->judul }}" class="img-thumbnail"
                                                            style="max-height: 100px;">
                                                    @else
                                                        <div class="bg-light rounded p-2">
                                                            <i class="bx bx-image" style="font-size: 2rem;"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $item->judul }}</td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 200px;" title="{{ strip_tags($item->deskripsi) }}">
                                                    {!! Str::limit($item->deskripsi, 50) !!}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if(is_array($item->hitungan))
                                                        {{ implode(', ', $item->hitungan) }}
                                                    @else
                                                        {{ $item->hitungan }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(is_array($item->keterangan_hitungan))
                                                        {{ implode(', ', $item->keterangan_hitungan) }}
                                                    @else
                                                        {{ $item->keterangan_hitungan }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 150px;" title="{{ strip_tags($item->keterangan_memilih) }}">
                                                        {!! Str::limit($item->keterangan_memilih, 30) !!}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($item->gambar_nilai)
                                                        <img src="{{ asset('storage/tentang/' . $item->gambar_nilai) }}"
                                                            alt="Gambar Nilai" class="img-thumbnail" style="max-height: 100px;">
                                                    @else
                                                        <div class="bg-light rounded p-2">
                                                            <i class="bx bx-image" style="font-size: 2rem;"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 150px;" title="{{ strip_tags($item->keterangan_nilai) }}">
                                                        {{ Str::limit(strip_tags($item->keterangan_nilai), 30) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('admin.tentang.show', $item->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="bx bx-show"></i>
                                                        </a>
                                                        <a href="{{ route('admin.tentang.edit', $item->id) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="bx bx-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.tentang.destroy', $item->id) }}" method="POST"
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
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="bx bx-info-circle mb-2" style="font-size: 3rem;"></i>
                                                    <h5>Belum ada data tentang</h5>
                                                    <p class="text-muted">Silakan tambahkan data tentang terlebih dahulu</p>
                                                    <a href="{{ route('admin.tentang.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus"></i> Tambah Tentang
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
