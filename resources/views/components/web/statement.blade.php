@php
  $prinsip = [
      ['01 / INTEGRATED', 'principle1', 'Tersambung ke sistem Anda', 'Website, sistem web, dan aplikasi mobile memakai data yang sama, jadi tiap divisi cukup input sekali.'],
      ['02 / AI ACCELERATED', 'principle2', 'AI di tempat yang tepat', 'AI mempercepat pengembangan di sisi kami, dan kami pasang di produk Anda hanya saat memang dibutuhkan.'],
      ['03 / HUMAN VERIFIED', 'principle3', 'Diperiksa oleh engineer', 'Engineer kami meninjau setiap alur integrasi dan baris kode sebelum rilis sampai ke pengguna Anda.'],
  ];
@endphp
<section class="rb-section rb-paper px-6">
  <div class="page-container">
    <h2 class="rb-h2 max-w-3xl !text-3xl md:!text-5xl md:!leading-tight" data-i18n="rb.statement">Kami menulis kode lebih
      cepat dengan AI. Engineer kami yang memutuskan apa yang dirilis.</h2>
    <div class="mt-14 grid gap-8 md:grid-cols-3">
      @foreach ($prinsip as [$tag, $k, $judul, $desc])
        <div class="rb-pillar">
          <p class="rb-eyebrow">{{ $tag }}</p>
          <h3 class="mt-3 text-base font-semibold text-navy" data-i18n="rb.{{ $k }}.title">{{ $judul }}</h3>
          <p class="mt-2 text-xs leading-relaxed text-muted" data-i18n="rb.{{ $k }}.desc">{{ $desc }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>
