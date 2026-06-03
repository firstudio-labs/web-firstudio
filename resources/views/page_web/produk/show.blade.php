@extends('template_web.layout')

@section('content')
  <section class="border-b border-gray-200 bg-gray-50 py-4">
    <div class="mx-auto w-full max-w-3xl px-6">
      @include('components.web.breadcrumb', [
        'items' => [
          ['url' => route('web.beranda.index'), 'label' => 'Beranda', 'i18n' => 'nav.home'],
          ['url' => route('web.produk.index'), 'label' => 'Portofolio', 'i18n' => 'nav.portfolio'],
          ['label' => $produk->judul, 'current' => true],
        ],
      ])
    </div>
  </section>

  <section class="bg-gray-50 px-6 py-12 text-gray-900">
    <div class="mx-auto w-full max-w-3xl">
      @if($produk->gambar)
        <div class="mb-8 overflow-hidden rounded-2xl border border-gray-200 shadow-lg">
          <img
            src="{{ asset('storage/produk/' . $produk->gambar) }}"
            alt="{{ $produk->judul }}"
            class="h-auto w-full max-h-[480px] object-cover"
            width="800"
            height="480"
          />
        </div>
      @endif

      <div class="space-y-6">
        @if($produk->kategoriProduk)
          <span class="portfolio-badge">
            <span data-i18n="portfolio.show.category">Kategori</span>: {{ $produk->kategoriProduk->kategori_produk }}
          </span>
        @endif

        <h1 class="font-primary text-3xl font-bold text-gray-900 md:text-4xl">
          {{ $produk->judul }}
        </h1>

        <div class="prose prose--light max-w-none text-gray-700">
          {!! $produk->deskripsi !!}
        </div>

        @if($produk->link)
          <a
            href="{{ $produk->link }}"
            target="_blank"
            rel="noopener noreferrer"
            class="btn btn-primary inline-flex items-center gap-2"
            data-i18n="portfolio.show.visit"
          >
            Arahkan ke Website
          </a>
        @endif
      </div>
    </div>
  </section>
@endsection
