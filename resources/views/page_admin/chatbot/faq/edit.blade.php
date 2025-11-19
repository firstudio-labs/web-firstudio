@extends('template_admin.layout')

@section('content')
  <div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Edit FAQ Chatbot</h1>
      <a href="{{ route('admin.chatbot.faq.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card shadow mb-4">
      <div class="card-body">
        <form action="{{ route('admin.chatbot.faq.update', $faq) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="question">Pertanyaan</label>
            <input
              type="text"
              class="form-control @error('question') is-invalid @enderror"
              id="question"
              name="question"
              value="{{ old('question', $faq->question) }}"
              required
            />
            @error('question')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="answer">Jawaban</label>
            <textarea
              class="form-control @error('answer') is-invalid @enderror"
              id="answer"
              name="answer"
              rows="6"
              required
            >{{ old('answer', $faq->answer) }}</textarea>
            @error('answer')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Aktif</label>
          </div>
          <button type="submit" class="btn btn-primary">Perbarui</button>
        </form>
      </div>
    </div>
  </div>
@endsection

