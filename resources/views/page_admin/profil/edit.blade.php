@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profil /</span> Edit Profil</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Profil Perusahaan</h5>
                        <a href="{{ route('admin.profil.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.profil.update', $profil->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Perusahaan</label>
                                    <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror"
                                        name="nama_perusahaan"
                                        value="{{ old('nama_perusahaan', $profil->nama_perusahaan) }}" required>
                                    @error('nama_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No. Telepon</label>
                                    <input type="text"
                                        class="form-control @error('no_telp_perusahaan') is-invalid @enderror"
                                        name="no_telp_perusahaan"
                                        value="{{ old('no_telp_perusahaan', $profil->no_telp_perusahaan) }}" required>
                                    @error('no_telp_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Logo Perusahaan</label>
                                    <input type="file" class="form-control @error('logo_perusahaan') is-invalid @enderror"
                                        id="logo_perusahaan" name="logo_perusahaan" accept="image/*" />
                                    <small class="text-muted">Format: JPG, JPEG, PNG, GIF, SVG. Maksimal 2MB</small>
                                    @error('logo_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Alamat</label>
                                    <x-map-input
                                        label="Alamat Perusahaan"
                                        addressId="alamat_perusahaan"
                                        addressName="alamat_perusahaan"
                                        :address="old('alamat_perusahaan', $profil->alamat_perusahaan)"
                                        latitudeId="latitude"
                                        latitudeName="latitude"
                                        :latitude="old('latitude', $profil->latitude)"
                                        longitudeId="longitude"
                                        longitudeName="longitude"
                                        :longitude="old('longitude', $profil->longitude)"
                                        modalId=""
                                    />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email_perusahaan') is-invalid @enderror"
                                        name="email_perusahaan"
                                        value="{{ old('email_perusahaan', $profil->email_perusahaan) }}" required>
                                    @error('email_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Instagram</label>
                                    <input type="text"
                                        class="form-control @error('instagram_perusahaan') is-invalid @enderror"
                                        name="instagram_perusahaan"
                                        value="{{ old('instagram_perusahaan', $profil->instagram_perusahaan) }}"
                                        placeholder="Masukkan username Instagram">
                                    @error('instagram_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Facebook</label>
                                    <input type="text"
                                        class="form-control @error('facebook_perusahaan') is-invalid @enderror"
                                        name="facebook_perusahaan"
                                        value="{{ old('facebook_perusahaan', $profil->facebook_perusahaan) }}"
                                        placeholder="Masukkan username Facebook">
                                    @error('facebook_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Twitter</label>
                                    <input type="text"
                                        class="form-control @error('twitter_perusahaan') is-invalid @enderror"
                                        name="twitter_perusahaan"
                                        value="{{ old('twitter_perusahaan', $profil->twitter_perusahaan) }}"
                                        placeholder="Masukkan username Twitter">
                                    @error('twitter_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="text"
                                        class="form-control @error('linkedin_perusahaan') is-invalid @enderror"
                                        name="linkedin_perusahaan"
                                        value="{{ old('linkedin_perusahaan', $profil->linkedin_perusahaan) }}"
                                        placeholder="Masukkan username LinkedIn">
                                    @error('linkedin_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection