@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profil /</span> Detail Profil</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Profil Perusahaan</h5>
                        <div>
                            <a href="{{ route('admin.profil.edit', $profil->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.profil.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Perusahaan</label>
                                <p>{{ $profil->nama_perusahaan }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">No. Telepon</label>
                                <p>{{ $profil->no_telp_perusahaan }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Logo Perusahaan</label>
                                <p>
                                    <img src="{{ asset('storage/profil/' . $profil->logo_perusahaan) }}" alt="Logo Perusahaan" class="img-fluid" style="max-width: 100px;">
                                </p>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <p>{{ $profil->alamat_perusahaan }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Latitude & Longitude</label>
                                <p>{{ $profil->latitude }}, {{ $profil->longitude }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <p>{{ $profil->email_perusahaan }}</p>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Media Sosial</label>
                                <div class="d-flex gap-2">
                                    @if($profil->instagram_perusahaan)
                                        <a href="https://instagram.com/{{ $profil->instagram_perusahaan }}" target="_blank"
                                            class="btn btn-danger">
                                            <i class="bx bxl-instagram"></i> Instagram
                                        </a>
                                    @endif
                                    @if($profil->facebook_perusahaan)
                                        <a href="https://facebook.com/{{ $profil->facebook_perusahaan }}" target="_blank"
                                            class="btn btn-primary">
                                            <i class="bx bxl-facebook"></i> Facebook
                                        </a>
                                    @endif
                                    @if($profil->twitter_perusahaan)
                                        <a href="https://twitter.com/{{ $profil->twitter_perusahaan }}" target="_blank"
                                            class="btn btn-info">
                                            <i class="bx bxl-twitter"></i> Twitter
                                        </a>
                                    @endif
                                    @if($profil->linkedin_perusahaan)
                                        <a href="https://linkedin.com/in/{{ $profil->linkedin_perusahaan }}" target="_blank"
                                            class="btn btn-primary">
                                            <i class="bx bxl-linkedin"></i> LinkedIn
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection