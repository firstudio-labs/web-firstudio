@extends('template_web.layout-ads')

@section('content')
    <main class="mx-auto w-full max-w-lg space-y-4 px-4 py-6">
        @forelse ($blocks as $block)
            @include('components.web.meta-ads-block', ['block' => $block])
        @empty
            <p class="text-center text-sm py-12 opacity-60">Konten sedang disiapkan.</p>
        @endforelse
    </main>
@endsection
