@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profil /</span> Data Profil</h4>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Profil Perusahaan</h5>
                        @if($profils && $profils->count() > 0)
                            <button class="btn btn-secondary" disabled title="Data profil sudah ada. Hanya bisa menginputkan 1 data profil.">
                                <i class="bx bx-plus"></i> Tambah Profil (Disabled)
                            </button>
                        @else
                            <a href="{{ route('admin.profil.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus"></i> Tambah Profil
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

                        @if($profils && $profils->count() > 0)
                            <div class="alert alert-info alert-dismissible" role="alert">
                                <i class="bx bx-info-circle"></i>
                                <strong>Informasi:</strong> Halaman profil hanya diizinkan memiliki 1 data saja. Untuk mengubah data, gunakan tombol edit pada data yang sudah ada.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Perusahaan</th>
                                        <th>No. Telepon</th>
                                        <th>Logo Perusahaan</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>Koordinat</th>
                                        <th>Media Sosial</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($profils as $index => $profil)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $profil->nama_perusahaan }}</td>
                                            <td>{{ $profil->no_telp_perusahaan }}</td>
                                            <td>
                                                <img src="{{ asset('storage/profil/' . $profil->logo_perusahaan) }}" alt="Logo Perusahaan" class="img-fluid" style="max-width: 100px;">
                                            </td>
                                            <td>{{ $profil->email_perusahaan }}</td>    
                                            <td>{{ $profil->alamat_perusahaan }}</td>
                                            <td>{{ $profil->latitude }}, {{ $profil->longitude }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    @if($profil->instagram_perusahaan)
                                                        <a href="https://instagram.com/{{ $profil->instagram_perusahaan }}"
                                                            target="_blank" class="btn btn-sm btn-danger">
                                                            <i class="bx bxl-instagram"></i>
                                                        </a>
                                                    @endif
                                                    @if($profil->facebook_perusahaan)
                                                        <a href="https://facebook.com/{{ $profil->facebook_perusahaan }}"
                                                            target="_blank" class="btn btn-sm btn-primary">
                                                            <i class="bx bxl-facebook"></i>
                                                        </a>
                                                    @endif
                                                    @if($profil->twitter_perusahaan)
                                                        <a href="https://twitter.com/{{ $profil->twitter_perusahaan }}"
                                                            target="_blank" class="btn btn-sm btn-info">
                                                            <i class="bx bxl-twitter"></i>
                                                        </a>
                                                    @endif
                                                    @if($profil->linkedin_perusahaan)
                                                        <a href="https://linkedin.com/in/{{ $profil->linkedin_perusahaan }}"
                                                            target="_blank" class="btn btn-sm btn-primary">
                                                            <i class="bx bxl-linkedin"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.profil.show', $profil->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="bx bx-show"></i>
                                                    </a>
                                                    <a href="{{ route('admin.profil.edit', $profil->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bx bx-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.profil.destroy', $profil->id) }}" method="POST"
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
                                                    <i class="bx bx-building mb-2" style="font-size: 3rem;"></i>
                                                    <h5>Belum ada data profil</h5>
                                                    <p class="text-muted">Silakan tambahkan data profil terlebih dahulu</p>
                                                    <a href="{{ route('admin.profil.create') }}" class="btn btn-primary">
                                                        <i class="bx bx-plus"></i> Tambah Profil
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

@section('scripts')
    <script>
        // Mencegah navigasi ke halaman create jika sudah ada data
        @if($profils && $profils->count() > 0)
            // Disable semua link yang mengarah ke route profil.create
            document.addEventListener('DOMContentLoaded', function() {
                const createLinks = document.querySelectorAll('a[href*="profil/create"]');
                createLinks.forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        alert('Data profil sudah ada. Hanya diizinkan memiliki 1 data profil saja. Silakan edit data yang sudah ada.');
                        return false;
                    });
                });
            });
        @endif
    </script>
@endsection