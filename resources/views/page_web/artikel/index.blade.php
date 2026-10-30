@extends('template_web.layout')

@section('content')
  @php
    $covers = ['rb-cover', 'rb-cover rb-cover--brand', 'rb-cover rb-cover--tint'];
    $authorOf = fn ($a) => $a->penulis ?: 'Tim Firstudio';
  @endphp

  <x-web.page-hero title="Catatan dari tim Firstudio." title-i18n="rb.blog.hero.title" crumb="Blog"
    crumb-i18n="nav.blog"
    subtitle="Tulisan tentang AI, sistem web, dan aplikasi mobile, dari proyek yang kami kerjakan sendiri."
    subtitle-i18n="rb.blog.hero.desc" />

  <section class="rb-section rb-paper px-6 !pt-20">
    <div class="page-container space-y-8">
      <nav class="flex flex-wrap gap-2" aria-label="Filter kategori">
        <a href="{{ route('web.artikel.index') }}" class="rb-chip {{ $kategori === 'all' ? 'is-active' : '' }}"
          data-i18n="rb.filter.all">Semua</a>
        @foreach ($kategori_artikels as $kat)
          <a href="{{ route('web.artikel.index', ['kategori' => $kat->slug]) }}"
            class="rb-chip {{ $kategori === $kat->slug ? 'is-active' : '' }}">{{ $kat->kategori_artikel }}</a>
        @endforeach
      </nav>

      @if ($featured ?? null)
        <a href="{{ route('web.artikel.show', $featured->slug) }}" class="rb-card group grid md:grid-cols-[1fr_1fr]">
          <div class="relative min-h-[16rem] bg-navy">
            @if ($featured->gambar)
              <img src="{{ asset('storage/artikel/' . $featured->gambar) }}" alt="" class="absolute inset-0 h-full w-full object-cover" />
            @else
              <span class="rb-eyebrow absolute left-6 top-6" data-i18n="rb.blog.featured">Artikel Pilihan</span>
            @endif
          </div>
          <div class="flex flex-col justify-center p-8 md:p-10">
            <p class="rb-eyebrow">{{ $featured->kategoriArtikel?->kategori_artikel ?? 'Blog' }}</p>
            <h2 class="mt-4 text-2xl font-semibold leading-snug text-navy group-hover:text-brand">{{ $featured->judul }}</h2>
            <p class="mt-3 line-clamp-3 text-xs leading-relaxed text-muted">
              {{ \Illuminate\Support\Str::limit(strip_tags($featured->isi ?? ''), 170) }}</p>
            <div class="mt-6 flex items-center justify-between text-xs">
              <span class="flex items-center gap-2 text-muted"><span class="h-3.5 w-3.5 rounded-full bg-navy"></span>{{ $authorOf($featured) }}</span>
              <span class="rb-link"><span data-i18n="rb.blog.read">Baca artikel</span> →</span>
            </div>
          </div>
        </a>
      @endif

      <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($artikels as $i => $artikel)
          <a href="{{ route('web.artikel.show', $artikel->slug) }}" class="rb-card group flex flex-col">
            <div class="{{ $artikel->gambar ? 'aspect-[16/7.5] overflow-hidden bg-tint' : $covers[$i % 3] }}">
              @if ($artikel->gambar)
                <img src="{{ asset('storage/artikel/' . $artikel->gambar) }}" alt="" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]" loading="lazy" />
              @endif
            </div>
            <div class="flex flex-1 flex-col p-5">
              <p class="rb-eyebrow">{{ $artikel->kategoriArtikel?->kategori_artikel ?? 'Blog' }}</p>
              <h3 class="mt-2 text-sm font-semibold leading-snug text-navy group-hover:text-brand">{{ $artikel->judul }}</h3>
              <p class="mt-auto flex items-center gap-2 pt-4 text-[0.6875rem] text-muted">
                <span class="h-3.5 w-3.5 rounded-full bg-navy"></span>{{ $authorOf($artikel) }}
              </p>
            </div>
          </a>
        @empty
          <p class="col-span-full py-16 text-center text-muted" data-i18n="home.articles.empty">Belum ada artikel.</p>
        @endforelse
      </div>

      @if ($artikels->hasPages())
        <div class="flex justify-center gap-3 pt-2">
          @if (! $artikels->onFirstPage())
            <a href="{{ $artikels->previousPageUrl() }}" class="rb-btn rb-btn--line" data-i18n="rb.prev">← Sebelumnya</a>
          @endif
          @if ($artikels->hasMorePages())
            <a href="{{ $artikels->nextPageUrl() }}" class="rb-btn rb-btn--line" data-i18n="rb.blog.more">Muat Artikel Lainnya ↓</a>
          @endif
        </div>
      @endif
    </div>
  </section>

  <x-web.cta-consultation />
@endsection
