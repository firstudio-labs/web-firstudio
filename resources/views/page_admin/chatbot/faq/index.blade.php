@extends('template_admin.layout')

@section('content')
  <div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Chatbot FAQ</h1>
      <a href="{{ route('admin.chatbot.faq.create') }}" class="btn btn-primary">Tambah FAQ</a>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>#</th>
                <th>Pertanyaan</th>
                <th>Status</th>
                <th class="text-right">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($faqs as $index => $faq)
                <tr>
                  <td>{{ $faqs->firstItem() + $index }}</td>
                  <td>{{ $faq->question }}</td>
                  <td>
                    @if($faq->is_active)
                      <span class="badge badge-success">Aktif</span>
                    @else
                      <span class="badge badge-secondary">Nonaktif</span>
                    @endif
                  </td>
                  <td class="text-right">
                    <a href="{{ route('admin.chatbot.faq.edit', $faq) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.chatbot.faq.destroy', $faq) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus FAQ ini?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center py-4">Belum ada FAQ.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
        {{ $faqs->links() }}
      </div>
    </div>
  </div>
@endsection

