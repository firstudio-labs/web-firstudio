@extends('template_web.layout')

@section('content')
  <x-web.page-hero title="Lihat apa yang sudah kami bangun untuk klien." title-i18n="rb.cases.hero.title"
    crumb="Studi Kasus" crumb-i18n="nav.cases"
    subtitle="Pilih kategori untuk melihat proyek di bidang yang paling dekat dengan bisnis Anda."
    subtitle-i18n="rb.cases.hero.desc" />

  <section class="rb-section rb-paper px-6 !pt-20">
    <div class="page-container">
      <div class="flex flex-wrap items-center justify-between gap-4">
        <nav class="flex flex-wrap gap-2" aria-label="Filter kategori">
          <a href="{{ route('web.produk.index') }}" class="rb-chip {{ $kategori === 'all' ? 'is-active' : '' }}"
            data-i18n="rb.filter.all">Semua</a>
          @foreach ($kategori_produks as $kat)
            <a href="{{ route('web.produk.index', ['kategori' => $kat->slug]) }}"
              class="rb-chip {{ $kategori === $kat->slug ? 'is-active' : '' }}">{{ $kat->kategori_produk }}</a>
          @endforeach
        </nav>
        <p class="rb-eyebrow !text-muted">
          <span data-i18n="rb.cases.showing">Menampilkan</span> {{ $produks->count() }}
          <span data-i18n="rb.cases.of">dari</span> {{ $produks->total() }}
          <span data-i18n="rb.cases.projects">proyek</span>
        </p>
      </div>

      <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($produks as $produk)
          <a href="{{ route('web.produk.show', $produk->slug) }}" class="rb-card group flex flex-col">
            <div class="aspect-[411/240] overflow-hidden bg-tint">
              @if ($produk->gambar)
                <img src="{{ asset('storage/produk/' . $produk->gambar) }}" alt="{{ $produk->judul }}"
                  class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]" loading="lazy" />
              @endif
            </div>
            <div class="flex flex-1 flex-col p-5">
              <p class="rb-eyebrow">{{ $produk->kategoriProduk?->kategori_produk ?? 'Studi Kasus' }}</p>
              <h3 class="mt-2 text-base font-semibold text-navy">{{ $produk->judul }}</h3>
              <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-muted">
                {{ \Illuminate\Support\Str::limit(strip_tags($produk->deskripsi ?? ''), 100) }}</p>
              <span class="rb-link mt-auto pt-4"><span data-i18n="rb.cases.detail">Lihat detail proyek</span> ↗</span>
            </div>
          </a>
        @empty
          <p class="col-span-full py-16 text-center text-muted" data-i18n="portfolio.empty.title">Tidak ada project ditemukan</p>
        @endforelse

        @if ($produks->hasMorePages())
          <div class="rb-dark flex flex-col justify-end p-6">
            <p class="rb-eyebrow" data-i18n="rb.cases.full.eyebrow">Portofolio Lengkap</p>
            <p class="mt-4 text-5xl font-semibold">+{{ $produks->total() - $produks->count() }}</p>
            <p class="mt-2 text-sm font-semibold" data-i18n="rb.cases.full.title">proyek lain belum tampil di sini.</p>
            <p class="rb-lead mt-3 text-xs" data-i18n="rb.cases.full.desc">Minta portofolio lengkap saat konsultasi gratis. Kami pilihkan proyek yang paling dekat dengan kebutuhan Anda.</p>
            <a href="{{ route('web.contact.index') }}" class="rb-btn rb-btn--sky mt-6 self-start"
              data-i18n="rb.cases.full.cta">Jadwalkan Konsultasi →</a>
          </div>
        @endif
      </div>

      @if ($produks->hasPages())
        <div class="mt-10 flex justify-center gap-3">
          @if (! $produks->onFirstPage())
            <a href="{{ $produks->previousPageUrl() }}" class="rb-btn rb-btn--line" data-i18n="rb.prev">← Sebelumnya</a>
          @endif
          @if ($produks->hasMorePages())
            <a href="{{ $produks->nextPageUrl() }}" class="rb-btn rb-btn--line" data-i18n="cases.loadMore">Lihat Lebih Banyak</a>
          @endif
        </div>
      @endif
    </div>
  </section>

  <x-web.cta-consultation />
@endsection
