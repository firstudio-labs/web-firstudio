@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Testimoni /</span> Detail Testimoni</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Testimoni</h5>
                        <div>
                            <a href="{{ route('admin.testimoni.edit', $testimoni->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.testimoni.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if ($testimoni->gambar)
                                    <img src="{{ asset('storage/testimoni/' . $testimoni->gambar) }}"
                                        alt="Gambar {{ $testimoni->nama }}" class="img-fluid rounded">
                                @else
                                    <div class="bg-light rounded p-5 text-center">
                                        <i class="bx bx-user" style="font-size: 5rem;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <table class="table">
                                    <tr>
                                        <th style="width: 200px;">Nama</th>
                                        <td>{{ $testimoni->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td>{{ $testimoni->jabatan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Testimoni</th>
                                        <td>{{ $testimoni->testimoni }}</td>
                                    </tr>
                                    <tr>
                                        <th>Rating</th>
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i
                                                    class="bx bxs-star {{ $i <= $testimoni->rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                            ({{ $testimoni->rating }}/5)
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection