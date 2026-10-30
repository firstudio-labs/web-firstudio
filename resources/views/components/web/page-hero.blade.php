@props([
  'title',
  'titleI18n' => null,
  'subtitle' => null,
  'subtitleI18n' => null,
  'eyebrow' => null,
  'eyebrowI18n' => null,
  'crumb' => null,
  'crumbI18n' => null,
])

<section class="rb-hero">
  <div class="page-container rb-hero__inner">
    @if ($crumb)
      <p class="rb-crumb mb-3">
        <a href="{{ route('web.beranda.index') }}" data-i18n="nav.home">Beranda</a>
        <span class="mx-2">/</span>
        <span @if ($crumbI18n) data-i18n="{{ $crumbI18n }}" @endif>{{ $crumb }}</span>
      </p>
    @endif
    @if ($eyebrow)
      <p class="rb-eyebrow mb-4" @if ($eyebrowI18n) data-i18n="{{ $eyebrowI18n }}" @endif>{{ $eyebrow }}</p>
    @endif
    <h1 class="rb-h1 max-w-3xl" @if ($titleI18n) data-i18n="{{ $titleI18n }}" @endif>{{ $title }}</h1>
    @if ($subtitle)
      <p class="rb-lead mt-5 max-w-xl"
        @if ($subtitleI18n) data-i18n="{{ $subtitleI18n }}" @endif>{{ $subtitle }}</p>
    @endif
  </div>
</section>
