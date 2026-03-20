@extends('template_admin.layout')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan /</span> API Key</h4>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pengaturan API Key OpenRouter</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.settings.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label" for="openrouter_api_key">OpenRouter API Key <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="openrouter_api_key" name="openrouter_api_key" value="{{ old('openrouter_api_key', $openRouterApiKey) }}" placeholder="sk-or-v1-..." />
                                <div class="form-text">
                                    Dapatkan API Key dari <a href="https://openrouter.ai/keys" target="_blank">OpenRouter.ai</a>. Kosongkan jika ingin menggunakan nilai dari file .env.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
