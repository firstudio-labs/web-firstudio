@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profil /</span> Tambah Profil</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Form Tambah Profil</h5>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="alert alert-info" role="alert">
                            <i class="bx bx-info-circle"></i>
                            <strong>Informasi:</strong> Halaman profil hanya diizinkan memiliki 1 data saja. Pastikan data yang Anda input sudah benar sebelum menyimpan.
                        </div>

                        <form action="{{ route('admin.profil.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="nama_perusahaan">Nama Perusahaan</label>
                                    <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror"
                                        id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}"
                                        placeholder="Masukkan nama perusahaan" />
                                    @error('nama_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="no_telp_perusahaan">No. Telepon</label>
                                    <input type="text" class="form-control @error('no_telp_perusahaan') is-invalid @enderror"
                                        id="no_telp_perusahaan" name="no_telp_perusahaan"
                                        value="{{ old('no_telp_perusahaan') }}" placeholder="Masukkan nomor telepon" />
                                    @error('no_telp_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <x-map-input
                                        label="Alamat Perusahaan"
                                        addressId="alamat_perusahaan"
                                        addressName="alamat_perusahaan"
                                        :address="old('alamat_perusahaan')"
                                        latitudeId="latitude"
                                        latitudeName="latitude"
                                        :latitude="old('latitude')"
                                        longitudeId="longitude"
                                        longitudeName="longitude"
                                        :longitude="old('longitude')"
                                        modalId=""
                                    />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="email_perusahaan">Email</label>
                                    <input type="email" class="form-control @error('email_perusahaan') is-invalid @enderror"
                                        id="email_perusahaan" name="email_perusahaan"
                                        value="{{ old('email_perusahaan') }}" placeholder="Masukkan email perusahaan" />
                                    @error('email_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="instagram_perusahaan">Instagram</label>
                                    <input type="text" class="form-control @error('instagram_perusahaan') is-invalid @enderror"
                                        id="instagram_perusahaan" name="instagram_perusahaan"
                                        value="{{ old('instagram_perusahaan') }}"
                                        placeholder="Masukkan link Instagram" />
                                    @error('instagram_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="facebook_perusahaan">Facebook</label>
                                    <input type="text" class="form-control @error('facebook_perusahaan') is-invalid @enderror"
                                        id="facebook_perusahaan" name="facebook_perusahaan"
                                        value="{{ old('facebook_perusahaan') }}"
                                        placeholder="Masukkan link Facebook" />
                                    @error('facebook_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="twitter_perusahaan">Twitter</label>
                                    <input type="text" class="form-control @error('twitter_perusahaan') is-invalid @enderror"
                                        id="twitter_perusahaan" name="twitter_perusahaan"
                                        value="{{ old('twitter_perusahaan') }}"
                                        placeholder="Masukkan link Twitter" />
                                    @error('twitter_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="linkedin_perusahaan">LinkedIn</label>
                                    <input type="text" class="form-control @error('linkedin_perusahaan') is-invalid @enderror"
                                        id="linkedin_perusahaan" name="linkedin_perusahaan"
                                        value="{{ old('linkedin_perusahaan') }}"
                                        placeholder="Masukkan link LinkedIn" />
                                    @error('linkedin_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="logo_perusahaan">Logo Perusahaan</label>
                                    <input type="file" class="form-control @error('logo_perusahaan') is-invalid @enderror"
                                        id="logo_perusahaan" name="logo_perusahaan" accept="image/*" />
                                    <small class="text-muted">Format: JPG, JPEG, PNG, GIF, SVG. Maksimal 2MB</small>
                                    @error('logo_perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <a href="{{ route('admin.profil.index') }}" class="btn btn-outline-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
