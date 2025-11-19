@php
    use Illuminate\Support\Str;
@endphp

@extends('template_admin.layout')

@section('content')
  <div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Chatbot Sessions</h1>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>#</th>
                <th>Session Token</th>
                <th>Last Activity</th>
                <th>Unread User Msg</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($sessions as $index => $session)
                <tr>
                  <td>{{ $sessions->firstItem() + $index }}</td>
                  <td><span class="badge badge-secondary">{{ Str::limit($session->session_token, 12) }}</span></td>
                  <td>{{ optional($session->last_activity)->diffForHumans() ?? 'Belum ada' }}</td>
                  <td>
                    @if($session->unread_count > 0)
                      <span class="badge badge-danger">{{ $session->unread_count }}</span>
                    @else
                      <span class="badge badge-success">0</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('admin.chatbot.sessions.show', $session) }}" class="btn btn-sm btn-primary">
                      Lihat Percakapan
                    </a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center py-4">Belum ada sesi percakapan.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
        {{ $sessions->links() }}
      </div>
    </div>
  </div>
@endsection

