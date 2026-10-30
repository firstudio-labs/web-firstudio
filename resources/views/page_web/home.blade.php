@extends('template_web.layout')

@section('content')
  @php
    $layananList = [
        ['01', 'ai', route('web.layanan.itconsul'), 'AI Integration', 'Chatbot, AI agent, dan knowledge base yang menjawab dari dokumen dan data perusahaan Anda.'],
        ['02', 'web', route('web.layanan.website'), 'Sistem Berbasis Web', 'Dashboard, CRM, dan sistem internal yang membuat data antar divisi cukup diinput sekali.'],
        ['03', 'mobile', route('web.layanan.mobile'), 'Mobile Apps', 'Aplikasi Android dan iOS yang terhubung langsung ke sistem internal Anda.'],
        ['04', 'site', route('web.layanan.company'), 'Pembuatan Website', 'Company profile, landing page, dan e-commerce yang cepat dimuat dan siap SEO.'],
    ];
    $langkah = [
        ['01', 'step1', 'Discovery Call', 'Kami mendengarkan tujuan bisnis dan masalah yang ingin Anda selesaikan.'],
        ['02', 'step2', 'Audit Operasional', 'Kami memetakan alur kerja dan sistem yang sudah berjalan di perusahaan Anda.'],
        ['03', 'step3', 'Opportunity Mapping', 'Kami menandai proses yang paling layak dibantu AI, dan proses yang tidak perlu.'],
        ['04', 'step4', 'Proposal & Roadmap', 'Anda menerima usulan solusi, lingkup kerja, dan urutan pengerjaannya.'],
        ['05', 'step5', 'Development', 'Engineer kami membangun bertahap, dengan demo berkala untuk masukan Anda.'],
        ['06', 'step6', 'Handover & Testing', 'Kami menguji sistem bersama tim Anda, lalu menyerahkannya lengkap dengan pelatihan.'],
    ];
    $kasus = ($produk ?? collect())->values();
    $kasusUtama = $kasus->first();
    $kasusLain = $kasus->slice(1, 4);
    $quote = $testimoni->first() ?? null;
  @endphp

  {{-- Hero --}}
  <section class="rb-hero">
    <div class="page-container rb-hero__inner !pt-12 !pb-20 grid items-center gap-10 lg:grid-cols-[1.05fr_1fr]">
      <div>
        <h1 class="rb-h1 max-w-xl" data-i18n="rb.home.hero.title">AI yang tersambung ke data dan sistem perusahaan Anda.</h1>
        <p class="rb-lead mt-6 max-w-md" data-i18n="rb.home.hero.desc">Firstudio membangun chatbot, AI agent, dan
          knowledge base, lalu menyambungkannya ke aplikasi yang dipakai tim setiap hari. Engineer kami memeriksa setiap
          rilis sebelum sampai ke pengguna.</p>
        <div class="mt-8 flex flex-wrap items-center gap-3">
          <a href="{{ route('web.contact.index') }}" class="rb-btn rb-btn--sky" data-i18n="rb.home.hero.ctaConsult">Jadwalkan
            Konsultasi →</a>
          <a href="{{ route('web.produk.index') }}" class="rb-btn rb-btn--ghost" data-i18n="rb.home.hero.ctaCases">Lihat
            Studi Kasus</a>
        </div>
      </div>
      <img src="{{ asset('web/assets/rebrand/hero-visual.png') }}" alt="" class="mx-auto w-full max-w-[600px]" loading="eager" />
    </div>
  </section>

  {{-- Clients (dari testimoni) --}}
  @if ($testimoni->isNotEmpty())
    <section class="bg-white px-6 py-14">
      <div class="page-container text-center">
        <p class="rb-eyebrow !text-muted" data-i18n="rb.home.clients">Dipercaya oleh</p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-x-12 gap-y-4 text-sm font-semibold tracking-wide text-muted">
          @foreach ($testimoni->unique('nama') as $item)
            @if ($item->gambar)
              <img src="{{ asset('storage/testimoni/' . $item->gambar) }}" alt="{{ $item->nama }}" title="{{ $item->nama }}"
                class="h-10 w-auto max-w-[9rem] object-contain grayscale" loading="lazy" />
            @else
              <span>{{ $item->nama }}</span>
            @endif
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- Layanan --}}
  <section class="rb-section rb-paper px-6 !py-20">
    <div class="page-container">
      <p class="rb-eyebrow" data-i18n="rb.home.services.eyebrow">Layanan</p>
      <h2 class="rb-h2 mt-4 max-w-3xl" data-i18n="rb.home.services.title">Satu tim yang mengerjakan AI sekaligus sistem
        tempat AI itu berjalan.</h2>
      <div class="mt-12">
        @foreach ($layananList as [$no, $k, $url, $judul, $desc])
          <a href="{{ $url }}" class="rb-row-line group grid items-center gap-4 py-6 md:grid-cols-[4rem_1.2fr_2fr_2.5rem]">
            <span class="rb-eyebrow !text-muted">{{ $no }}</span>
            <h3 class="text-base font-semibold text-navy" data-i18n="rb.home.services.{{ $k }}.title">{{ $judul }}</h3>
            <p class="text-xs leading-relaxed text-muted" data-i18n="rb.home.services.{{ $k }}.desc">{{ $desc }}</p>
            <span class="flex h-9 w-9 items-center justify-center border border-line text-brand transition group-hover:bg-navy group-hover:text-white"
              aria-hidden="true">↗</span>
          </a>
        @endforeach
        <div class="rb-row-line"></div>
      </div>
    </div>
  </section>

  {{-- Produk sendiri --}}
  <section class="rb-section rb-dark px-6 !py-24">
    <div class="page-container">
      <p class="rb-eyebrow" data-i18n="rb.home.products.eyebrow">Produk Kami</p>
      <h2 class="rb-h2 mt-4 max-w-xl" data-i18n="rb.home.products.title">Kami juga menjalankan produk AI kami sendiri.</h2>
      <div class="mt-12 grid gap-8 md:grid-cols-2">
        @foreach ([
            ['screenshot-daycare.ai.id.png', 'PRODUK 01 · PAUD & DAYCARE', 'DaycareAI', 'Satu platform untuk admin, guru, dan orang tua di PAUD dan daycare. Admin mengelola operasional, orang tua memantau tumbuh kembang anak.', 'Kunjungi daycare.ai.id', 'https://daycare.ai.id'],
            ['screenshot-rekamin.com.png', 'PRODUK 02 · CATATAN SUARA & AI', 'Rekamin', 'Anda bicara, Rekamin menuliskannya. Hasilnya catatan rapi dari obrolan, ringkasan, dan daftar tindak lanjut.', 'Kunjungi rekamin.com', 'https://rekamin.com'],
        ] as $i => [$img, $tag, $nama, $desc, $cta, $url])
          <article>
            <img src="{{ asset('web/assets/rebrand/' . $img) }}" alt="{{ $nama }}" class="aspect-[2/1] w-full object-cover" loading="lazy" />
            <p class="rb-eyebrow mt-5">{{ $tag }}</p>
            <h3 class="mt-2 text-xl font-semibold">{{ $nama }}</h3>
            <p class="rb-lead mt-3 max-w-lg" data-i18n="rb.home.products.p{{ $i + 1 }}.desc">{{ $desc }}</p>
            <a href="{{ $url }}" target="_blank" rel="noopener" class="rb-link mt-4 inline-block">{{ $cta }} ↗</a>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <x-web.statement />

  {{-- Studi kasus --}}
  <section class="rb-section bg-white px-6">
    <div class="page-container">
      <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
          <p class="rb-eyebrow" data-i18n="rb.home.cases.eyebrow">Studi Kasus</p>
          <h2 class="rb-h2 mt-4 max-w-xl" data-i18n="rb.home.cases.title">Beberapa proyek yang sudah kami kerjakan.</h2>
        </div>
        <a href="{{ route('web.produk.index') }}" class="rb-link" data-i18n="rb.home.cases.all">Lihat semua proyek →</a>
      </div>
      @if ($kasusUtama)
        <div class="mt-10 grid gap-6 lg:grid-cols-[1.1fr_1fr]">
          <a href="{{ route('web.produk.show', $kasusUtama->slug) }}" class="rb-dark block p-6">
            <div class="aspect-[2/1] overflow-hidden bg-brand">
              @if ($kasusUtama->gambar)
                <img src="{{ asset('storage/produk/' . $kasusUtama->gambar) }}" alt="" class="h-full w-full object-cover" loading="lazy" />
              @endif
            </div>
            <p class="rb-eyebrow mt-6">{{ $kasusUtama->kategoriProduk?->kategori_produk ?? 'Studi Kasus' }}</p>
            <h3 class="mt-2 text-xl font-semibold">{{ $kasusUtama->judul }}</h3>
            <p class="rb-lead mt-3 line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($kasusUtama->deskripsi ?? ''), 140) }}</p>
          </a>
          <div class="divide-y divide-line">
            @foreach ($kasusLain as $item)
              <a href="{{ route('web.produk.show', $item->slug) }}" class="group flex items-center gap-4 py-4 first:pt-0">
                <div class="h-[5.5rem] w-32 shrink-0 overflow-hidden bg-tint">
                  @if ($item->gambar)
                    <img src="{{ asset('storage/produk/' . $item->gambar) }}" alt="" class="h-full w-full object-cover" loading="lazy" />
                  @endif
                </div>
                <div class="min-w-0 flex-1">
                  <p class="rb-eyebrow">{{ $item->kategoriProduk?->kategori_produk ?? 'Studi Kasus' }}</p>
                  <h3 class="mt-1 text-sm font-semibold text-navy">{{ $item->judul }}</h3>
                  <p class="mt-1 line-clamp-2 text-xs text-muted">{{ \Illuminate\Support\Str::limit(strip_tags($item->deskripsi ?? ''), 80) }}</p>
                </div>
                <span class="flex h-8 w-8 shrink-0 items-center justify-center border border-line text-brand group-hover:bg-navy group-hover:text-white"
                  aria-hidden="true">↗</span>
              </a>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </section>

  {{-- Proses --}}
  <section class="rb-section rb-paper px-6">
    <div class="page-container">
      <div class="grid gap-6 lg:grid-cols-[1.4fr_1fr] lg:items-end">
        <div>
          <p class="rb-eyebrow" data-i18n="rb.home.process.eyebrow">Cara Kerja · AI Readiness Consultation</p>
          <h2 class="rb-h2 mt-4 max-w-lg" data-i18n="rb.home.process.title">Enam langkah dari kebutuhan sampai sistem live.</h2>
        </div>
        <p class="rb-lead" data-i18n="rb.home.process.desc">Setiap langkah menghasilkan dokumen atau versi sistem yang bisa Anda periksa sebelum lanjut ke langkah berikutnya.</p>
      </div>
      <div class="mt-12 grid gap-x-8 gap-y-10 md:grid-cols-3">
        @foreach ($langkah as [$no, $k, $judul, $desc])
          <div class="rb-step-rule">
            <p class="rb-eyebrow">LANGKAH {{ $no }}</p>
            <h3 class="mt-3 text-base font-semibold text-navy" data-i18n="rb.{{ $k }}.title">{{ $judul }}</h3>
            <p class="mt-2 text-xs leading-relaxed text-muted" data-i18n="rb.{{ $k }}.desc">{{ $desc }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Testimoni --}}
  <section class="rb-section bg-white px-6">
    <div class="page-container max-w-5xl">
      <p class="rb-eyebrow" data-i18n="rb.home.testimonial.eyebrow">Testimoni</p>
      <blockquote class="mt-5 text-2xl font-medium leading-snug text-navy md:text-3xl">
        @if ($quote)
          “{{ $quote->testimoni }}”
        @else
          <span data-i18n="rb.home.testimonial.quote">“Pelayanannya ramah dan profesional. Website yang dibuat sesuai dengan keinginan saya, mudah digunakan, dan tampilannya terlihat lebih profesional.”</span>
        @endif
      </blockquote>
      <p class="mt-6 text-xs text-muted">
        <span class="mr-2 inline-block h-px w-8 bg-brand align-middle"></span>
        <strong class="text-navy">{{ $quote->nama ?? '[Nama Klien]' }}</strong>
        <span class="ml-2">{{ $quote->jabatan ?? '[Jabatan, Perusahaan]' }}</span>
      </p>
    </div>
  </section>

  <x-web.cta-consultation />
@endsection
