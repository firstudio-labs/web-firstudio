@extends('template_web.layout')

@section('content')
  <x-web.page-hero title="Agensi AI dan software untuk perusahaan Anda." title-i18n="rb.about.hero.title"
    crumb="Tentang" crumb-i18n="nav.aboutShort" eyebrow="Tentang Firstudio" eyebrow-i18n="rb.about.hero.eyebrow"
    subtitle="Firstudio mendampingi UKM dan korporasi lewat konsultasi IT, pembuatan website, pengembangan aplikasi, dan integrasi AI ke sistem perusahaan."
    subtitle-i18n="rb.about.hero.desc" />

  {{-- Siapa kami --}}
  <section class="rb-section rb-paper px-6">
    <div class="page-container grid gap-12 lg:grid-cols-[1.1fr_1fr]">
      <div>
        <p class="rb-eyebrow" data-i18n="rb.about.who.eyebrow">Siapa Kami</p>
        <h2 class="rb-h2 mt-4 max-w-md" data-i18n="rb.about.who.title">Kami membangun sistem untuk dipakai setiap hari,
          termasuk produk kami sendiri.</h2>
      </div>
      <div>
        @if (!empty($tentang?->deskripsi))
          <div class="space-y-4 text-sm leading-relaxed text-muted" data-cms-locale-html
            data-cms-id="{{ strip_tags($tentang->deskripsi) }}" data-cms-en="{{ strip_tags($tentang->deskripsi_en ?? '') }}">
            {!! $tentang->deskripsi !!}
          </div>
        @else
          <div class="space-y-4 text-sm leading-relaxed text-muted">
            <p data-i18n="rb.about.who.p1">Firstudio adalah digital agency di Semarang. Kami mendampingi UKM dan korporasi menghadapi tantangan era digital dengan solusi teknologi yang tepat guna.</p>
            <p data-i18n="rb.about.who.p2">Layanan kami mencakup konsultasi IT, pembuatan website, pengembangan aplikasi, dan company profile, disesuaikan dengan kebutuhan dan potensi setiap klien.</p>
          </div>
        @endif
        <dl class="mt-8 grid grid-cols-3 gap-6 border-t border-line pt-6">
          @foreach ([['24', 'PROYEK DIKERJAKAN', 'stat1'], ['2', 'PRODUK SENDIRI', 'stat2'], ['4', 'LAYANAN INTI', 'stat3']] as [$n, $l, $k])
            <div>
              <dd class="text-3xl font-semibold text-navy">{{ $n }}</dd>
              <dt class="rb-eyebrow mt-1 !text-muted" data-i18n="rb.about.{{ $k }}">{{ $l }}</dt>
            </div>
          @endforeach
        </dl>
      </div>
    </div>
  </section>

  {{-- Nilai FIRST --}}
  <section class="rb-section rb-dark px-6">
    <div class="page-container">
      <p class="rb-eyebrow" data-i18n="rb.about.values.eyebrow">Nilai Inti</p>
      <h2 class="rb-h2 mt-4" data-i18n="rb.about.values.title">Lima nilai di balik nama FIRST.</h2>
      <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-5">
        @foreach ([
            ['F', 'Future', 'Berorientasi pada masa depan dan inovasi berkelanjutan.', 'future'],
            ['I', 'Innovative', 'Menghadirkan ide kreatif yang solutif.', 'innovative'],
            ['R', 'Research', 'Berbasis data, riset, dan analisis yang mendalam.', 'research'],
            ['S', 'Solution', 'Memberikan solusi nyata sesuai kebutuhan klien.', 'solution'],
            ['T', 'Technology', 'Mengoptimalkan teknologi tepat guna untuk transformasi digital.', 'technology'],
        ] as [$huruf, $nama, $desc, $k])
          <div class="border-l border-white/20 pl-5">
            <p class="text-5xl font-semibold text-sky">{{ $huruf }}</p>
            <h3 class="mt-3 text-sm font-semibold">{{ $nama }}</h3>
            <p class="rb-lead mt-2 text-xs" data-i18n="rb.about.value.{{ $k }}">{{ $desc }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <x-web.statement />
  <x-web.cta-consultation />
@endsection
