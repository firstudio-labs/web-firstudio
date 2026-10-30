@php
  $currentRoute = Route::currentRouteName();
  $isActive = fn ($route) => in_array($currentRoute, (array) $route) ? 'nav-active' : '';
  $layananRoutes = ['web.layanan.website', 'web.layanan.mobile', 'web.layanan.company', 'web.layanan.itconsul', 'web.layanan.itoutsourcing', 'web.layanan.website.katalog'];
@endphp

<header class="navbar navbar--figma">
  <nav class="page-container flex h-24 items-center justify-between gap-4" aria-label="Navigasi utama">
    <a href="{{ route('web.beranda.index') }}" class="flex shrink-0 items-center gap-2">
      <img src="{{ asset('web/assets/logo-white.png') }}" alt="" class="h-8 w-8 object-contain" width="32"
        height="32" />
      <span class="text-sm font-bold tracking-wider text-white">FIRSTUDIO</span>
    </a>

    <div class="hidden flex-1 items-center justify-center gap-8 lg:flex">
      <a href="{{ route('web.beranda.index') }}" class="nav-link {{ $isActive('web.beranda.index') }}"
        data-i18n="nav.home">Beranda</a>
      <a href="{{ route('web.about.index') }}" class="nav-link {{ $isActive('web.about.index') }}"
        data-i18n="nav.aboutShort">Tentang</a>
      <div class="relative" id="services-menu">
        <button type="button"
          class="nav-link flex items-center gap-1 {{ $isActive($layananRoutes) }}"
          data-services-button aria-expanded="false">
          <span data-i18n="nav.solusi">Solusi</span>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" fill="none"
            stroke="currentColor" stroke-width="2" data-chevron>
            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
          </svg>
        </button>
        <div
          class="nav-services-panel nav-services-panel--figma pointer-events-none absolute left-1/2 top-full z-[110] mt-2 w-72 -translate-x-1/2 py-2 opacity-0 transition-all duration-200 data-[open=true]:pointer-events-auto data-[open=true]:opacity-100"
          data-services-panel data-open="false">
          <ul>
            <li><a href="{{ route('web.layanan.itconsul') }}" class="block px-4 py-2.5 text-[0.8125rem] text-white/80 transition hover:bg-white/10 hover:text-white"
                data-i18n="rb.home.services.ai.title">AI Integration</a></li>
            <li><a href="{{ route('web.layanan.website') }}" class="block px-4 py-2.5 text-[0.8125rem] text-white/80 transition hover:bg-white/10 hover:text-white"
                data-i18n="rb.home.services.web.title">Sistem Berbasis Web</a></li>
            <li><a href="{{ route('web.layanan.mobile') }}" class="block px-4 py-2.5 text-[0.8125rem] text-white/80 transition hover:bg-white/10 hover:text-white"
                data-i18n="rb.home.services.mobile.title">Mobile Apps</a></li>
            <li><a href="{{ route('web.layanan.company') }}" class="block px-4 py-2.5 text-[0.8125rem] text-white/80 transition hover:bg-white/10 hover:text-white"
                data-i18n="rb.home.services.site.title">Pembuatan Website</a></li>
          </ul>
        </div>
      </div>
      <a href="{{ route('web.produk.index') }}" class="nav-link {{ $isActive(['web.produk.index', 'web.produk.show']) }}"
        data-i18n="nav.cases">Studi Kasus</a>
      <a href="{{ route('web.artikel.index') }}" class="nav-link {{ $isActive(['web.artikel.index', 'web.artikel.show']) }}"
        data-i18n="nav.blog">Blog</a>
      <a href="{{ route('web.contact.index') }}" class="nav-link {{ $isActive('web.contact.index') }}"
        data-i18n="nav.contact">Kontak</a>
    </div>

    <div class="hidden items-center gap-6 lg:flex">
      <div class="figma-lang-pill locale-toggle" role="group" aria-label="Pilih bahasa">
        <button type="button" class="locale-toggle__btn locale-toggle__btn--active" data-locale-toggle="id"
          aria-pressed="true">ID</button>
        <span aria-hidden="true">|</span>
        <button type="button" class="locale-toggle__btn" data-locale-toggle="en" aria-pressed="false">EN</button>
      </div>
      <a href="{{ route('web.contact.index') }}" class="rb-btn rb-btn--sky !py-2.5 !text-xs"
        data-i18n="nav.cta">Konsultasi Gratis</a>
    </div>

    <button type="button" class="rounded-lg p-2 lg:hidden" id="mobile-toggle" data-i18n-aria="nav.open"
      aria-label="Buka navigasi">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
        stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
  </nav>

  <div id="mobile-menu" class="border-t border-white/10 px-6 py-4 text-sm lg:hidden" hidden>
    <a href="{{ route('web.beranda.index') }}" class="{{ $isActive('web.beranda.index') }} block py-2.5"
      data-i18n="nav.home">Beranda</a>
    <a href="{{ route('web.about.index') }}" class="{{ $isActive('web.about.index') }} block py-2.5"
      data-i18n="nav.aboutShort">Tentang</a>
    <button type="button" class="flex w-full items-center justify-between py-2.5" data-mobile-services>
      <span data-i18n="nav.solusi">Solusi</span>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
      </svg>
    </button>
    <div class="mb-2 hidden space-y-1 border-l-2 border-sky pl-4" data-mobile-services-panel>
      <a href="{{ route('web.layanan.itconsul') }}" class="block py-1.5 text-white/70" data-i18n="rb.home.services.ai.title">AI Integration</a>
      <a href="{{ route('web.layanan.website') }}" class="block py-1.5 text-white/70" data-i18n="rb.home.services.web.title">Sistem Berbasis Web</a>
      <a href="{{ route('web.layanan.mobile') }}" class="block py-1.5 text-white/70" data-i18n="rb.home.services.mobile.title">Mobile Apps</a>
      <a href="{{ route('web.layanan.company') }}" class="block py-1.5 text-white/70" data-i18n="rb.home.services.site.title">Pembuatan Website</a>
    </div>
    <a href="{{ route('web.produk.index') }}" class="block py-2.5" data-i18n="nav.cases">Studi Kasus</a>
    <a href="{{ route('web.artikel.index') }}" class="block py-2.5" data-i18n="nav.blog">Blog</a>
    <a href="{{ route('web.contact.index') }}" class="block py-2.5" data-i18n="nav.contact">Kontak</a>
    <div class="figma-lang-pill locale-toggle mt-4 inline-flex">
      <button type="button" class="locale-toggle__btn locale-toggle__btn--active" data-locale-toggle="id">ID</button>
      <span>|</span>
      <button type="button" class="locale-toggle__btn" data-locale-toggle="en">EN</button>
    </div>
  </div>
</header>
