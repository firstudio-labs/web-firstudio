@props(['prefix', 'dark' => true])

<section id="process" class="rb-section {{ $dark ? 'rb-dark' : 'rb-paper' }} px-6">
  <div class="page-container">
    <div class="grid gap-6 lg:grid-cols-[1.4fr_1fr] lg:items-end">
      <div>
        <p class="rb-eyebrow" data-i18n="rb.layanan.process.eyebrow">Proses Pengerjaan</p>
        <h2 class="rb-h2 mt-4 max-w-lg" data-i18n="layanan.common.process.title">Proses Pengerjaan</h2>
      </div>
      <p class="rb-lead" data-i18n="layanan.common.process.subtitle">Kami mengikuti metodologi terstruktur untuk
        memastikan proyek Anda selesai tepat waktu dengan kualitas terbaik</p>
    </div>
    <div class="mt-12 grid gap-x-8 gap-y-10 md:grid-cols-3">
      @for ($i = 1; $i <= 6; $i++)
        <div class="rb-step-rule">
          <p class="rb-eyebrow">LANGKAH 0{{ $i }}</p>
          <h3 class="mt-3 text-base font-semibold {{ $dark ? '' : 'text-navy' }}" data-i18n="layanan.{{ $prefix }}.process.step{{ $i }}.title"></h3>
          <p class="rb-lead mt-2 text-xs {{ $dark ? '' : '!text-muted' }}" data-i18n="layanan.{{ $prefix }}.process.step{{ $i }}.desc"></p>
        </div>
      @endfor
    </div>
  </div>
</section>
