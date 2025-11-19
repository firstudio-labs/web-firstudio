@extends('template_admin.layout')

@section('content')
  <div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <h1 class="h3 mb-1 text-gray-800">Detail Percakapan</h1>
        <p class="mb-0 text-muted"><strong>Session:</strong> {{ $session->session_token }}</p>
      </div>
      <a href="{{ route('admin.chatbot.sessions.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
      <div class="col-lg-8 mb-4">
        <div class="card shadow">
          <div class="card-body" style="max-height: 60vh; overflow-y: auto;">
            @forelse($session->messages->sortBy('created_at') as $message)
              <div class="mb-3">
                <div class="small text-muted">
                  <strong>{{ strtoupper($message->role) }}</strong>
                  <span class="ml-2">{{ $message->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="border rounded p-3">
                  {!! nl2br(e($message->message)) !!}
                </div>
              </div>
            @empty
              <p class="text-center text-muted">Belum ada pesan.</p>
            @endforelse
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="card shadow">
          <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Balas Pengguna</h6>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.chatbot.sessions.respond', $session) }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="message">Pesan</label>
                <textarea
                  class="form-control @error('message') is-invalid @enderror"
                  name="message"
                  id="message"
                  rows="4"
                  required
                >{{ old('message') }}</textarea>
                @error('message')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
              <button type="submit" class="btn btn-primary btn-block">Kirim Balasan</button>
            </form>
          </div>
        </div>

        <div class="card shadow mt-4">
          <div class="card-body">
            <p class="mb-2"><strong>User Agent:</strong></p>
            <p class="text-muted">{{ $session->user_agent ?? '-' }}</p>
            <p class="mb-2"><strong>IP Address:</strong></p>
            <p class="text-muted">{{ $session->ip_address ?? '-' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

