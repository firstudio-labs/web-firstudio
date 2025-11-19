@extends('template_web.layout')

@section('content')
<!-- Breadcrumb -->
<section class="bg-black/50 py-4">
      <div class="mx-auto w-full max-w-4xl px-6">
        <nav class="flex items-center gap-2 text-sm text-gray-400">
          <a href="{{ route('web.beranda.index') }}" class="hover:text-white transition">Home</a>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
          <a href="{{ route('web.artikel.index') }}" class="hover:text-white transition">Articles</a>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
          <span class="text-white">{{ $artikel->judul }}</span>
        </nav>
      </div>
    </section>

    <!-- Article Header -->
    <section class="bg-black py-12">
      <div class="mx-auto w-full max-w-4xl px-6">
        @if($artikel->kategoriArtikel)
        <div class="mb-6">
          <span class="inline-block rounded-full bg-blue-500/10 px-4 py-1 text-sm font-medium text-blue-400">
            {{ $artikel->kategoriArtikel->kategori_artikel }}
          </span>
        </div>
        @endif
        <h1 class="mb-6 text-4xl font-bold leading-tight text-white md:text-5xl">
          {{ $artikel->judul }}
        </h1>
        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
          @if($artikel->penulis)
          <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>{{ $artikel->penulis }}</span>
          </div>
          @endif
          @if($artikel->created_at)
          <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>{{ $artikel->created_at->format('d F Y') }}</span>
          </div>
          @endif
          <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ ceil(str_word_count(strip_tags($artikel->isi)) / 200) }} min read</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Image -->
    @if($artikel->gambar)
    <section class="bg-black">
      <div class="mx-auto w-full max-w-4xl px-6">
        <div class="overflow-hidden rounded-2xl">
          <img
            src="{{ asset('storage/artikel/' . $artikel->gambar) }}"
            alt="{{ $artikel->judul }}"
            class="h-[400px] w-full object-cover md:h-[500px]"
          />
        </div>
      </div>
    </section>
    @endif

    <!-- Article Content -->
    <article class="bg-black py-12">
      <div class="mx-auto w-full max-w-4xl px-6">
        <div class="prose prose-invert prose-lg max-w-none">
          <div class="text-gray-300 leading-relaxed">
            {!! $artikel->isi !!}
          </div>
        </div>

        <!-- Share Buttons -->
        <div class="mt-12 border-t border-white/10 pt-8">
          <div class="flex flex-wrap items-center gap-4">
            <span class="text-sm font-medium text-gray-400">Bagikan artikel:</span>
            <div class="flex gap-3">
              <a
                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex h-10 w-10 items-center justify-center rounded-full border border-white/20 bg-white/5 text-gray-400 transition hover:border-blue-500 hover:bg-blue-500 hover:text-white"
                aria-label="Share on Facebook"
              >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                  <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
              </a>
              <a
                href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($artikel->judul) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex h-10 w-10 items-center justify-center rounded-full border border-white/20 bg-white/5 text-gray-400 transition hover:border-blue-400 hover:bg-blue-400 hover:text-white"
                aria-label="Share on Twitter"
              >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                  <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                </svg>
              </a>
              <a
                href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex h-10 w-10 items-center justify-center rounded-full border border-white/20 bg-white/5 text-gray-400 transition hover:border-blue-600 hover:bg-blue-600 hover:text-white"
                aria-label="Share on LinkedIn"
              >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </article>

    <!-- Related Articles -->
    @if($relatedArtikels->count() > 0)
    <section class="bg-black py-16">
      <div class="mx-auto w-full max-w-6xl px-6">
        <h2 class="mb-8 text-3xl font-bold text-white">Artikel Terkait</h2>
        <div class="grid gap-6 md:grid-cols-3">
          @foreach($relatedArtikels as $related)
            <a href="{{ route('web.artikel.show', $related->slug) }}" class="group">
              <div class="overflow-hidden rounded-xl">
                @if($related->gambar)
                  <img
                    src="{{ asset('storage/artikel/' . $related->gambar) }}"
                    alt="{{ $related->judul }}"
                    class="h-48 w-full object-cover transition-transform duration-300 group-hover:scale-105"
                  />
                @else
                  <div class="h-48 w-full bg-gradient-to-br from-blue-500/20 to-transparent flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-16 w-16 text-blue-400">
                      <path d="M19.5 21a3 3 0 003-3v-4.5a3 3 0 00-3-3h-15a3 3 0 00-3 3V18a3 3 0 003 3h15zM1.5 10.146V6a3 3 0 013-3h5.379a2.25 2.25 0 011.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 013 3v1.146A4.483 4.483 0 0019.5 9h-15a4.483 4.483 0 00-3 1.146z" />
                    </svg>
                  </div>
                @endif
              </div>
              <div class="mt-4">
                <span class="text-sm text-gray-400">
                  {{ $related->created_at ? $related->created_at->format('d F Y') : '' }}
                </span>
                <h3 class="mt-2 text-xl font-semibold text-white transition group-hover:text-blue-400 line-clamp-2">
                  {{ $related->judul }}
                </h3>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </section>
    @endif
@endsection
