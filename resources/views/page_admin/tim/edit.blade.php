@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tim /</span> Edit Tim</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Edit Tim</h5>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.tim.update', $tim->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama', $tim->nama) }}" required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="posisi" class="form-label">Posisi</label>
                                        <input type="text" class="form-control @error('posisi') is-invalid @enderror"
                                            id="posisi" name="posisi" value="{{ old('posisi', $tim->posisi) }}" required>
                                        @error('posisi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="gambar" class="form-label">Gambar</label>
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                            id="gambar" name="gambar">
                                        @error('gambar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if ($tim->gambar)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/tim/' . $tim->gambar) }}"
                                                    alt="Gambar {{ $tim->nama }}" class="img-thumbnail"
                                                    style="max-height: 200px;">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label for="quote" class="form-label">Quote</label>
                                        <textarea class="form-control @error('quote') is-invalid @enderror" id="quote"
                                            name="quote" rows="3" required>{{ old('quote', $tim->quote) }}</textarea>
                                        @error('quote')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="instagram" class="form-label">Instagram</label>
                                        <input type="text" class="form-control @error('instagram') is-invalid @enderror"
                                            id="instagram" name="instagram" value="{{ old('instagram', $tim->instagram) }}"
                                            required>
                                        @error('instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="linkedin" class="form-label">LinkedIn</label>
                                        <input type="text" class="form-control @error('linkedin') is-invalid @enderror"
                                            id="linkedin" name="linkedin" value="{{ old('linkedin', $tim->linkedin) }}"
                                            required>
                                        @error('linkedin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="facebook" class="form-label">Facebook</label>
                                        <input type="text" class="form-control @error('facebook') is-invalid @enderror"
                                            id="facebook" name="facebook" value="{{ old('facebook', $tim->facebook) }}"
                                            required>
                                        @error('facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="whatsapp" class="form-label">WhatsApp</label>
                                        <input type="text" class="form-control @error('whatsapp') is-invalid @enderror"
                                            id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $tim->whatsapp) }}"
                                            required>
                                        @error('whatsapp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('admin.tim.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection