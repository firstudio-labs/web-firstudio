<footer id="footer" class="footer footer--figma px-6 pb-8 pt-16 text-white">
  <div class="page-container">
    <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1.2fr]">
      <div class="space-y-4">
        <h3 class="text-lg font-semibold" data-i18n="footer.newsletter.title">Tetap Terhubung</h3>
        <p class="max-w-xs text-xs leading-relaxed text-white/70" data-i18n="footer.newsletter.desc">Dapatkan kabar
          produk baru dan penawaran dari Firstudio lewat email.</p>
        <div class="relative max-w-sm">
          <input type="email" data-i18n-placeholder="footer.newsletter.placeholder"
            placeholder="Masukkan email Anda"
            class="w-full border-0 bg-white/20 py-3 pl-4 pr-12 text-xs text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-sky/60" />
          <button type="button" aria-label="Kirim"
            class="absolute right-1.5 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center bg-white text-navy">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
              <path
                d="M3.105 2.289a.75.75 0 00-.826.95l1.414 4.925A1.5 1.5 0 005.135 9.25h6.115a.75.75 0 010 1.5H5.135a1.5 1.5 0 00-1.442 1.086l-1.414 4.926a.75.75 0 00.826.95 28.896 28.896 0 0015.293-7.154.75.75 0 000-1.115A28.897 28.897 0 003.105 2.289z" />
            </svg>
          </button>
        </div>
      </div>
      <div>
        <h4 class="mb-4 text-sm font-semibold" data-i18n="footer.quickLinks">Tautan Cepat</h4>
        <ul class="space-y-3 text-xs text-white/75">
          <li><a href="{{ route('web.beranda.index') }}" class="hover:text-white" data-i18n="nav.home">Beranda</a></li>
          <li><a href="{{ route('web.about.index') }}" class="hover:text-white" data-i18n="nav.aboutShort">Tentang</a>
          </li>
          <li><a href="{{ route('web.produk.index') }}" class="hover:text-white" data-i18n="nav.cases">Studi Kasus</a>
          </li>
          <li><a href="{{ route('web.contact.index') }}" class="hover:text-white" data-i18n="nav.contact">Kontak</a>
          </li>
        </ul>
      </div>
      <div>
        <h4 class="mb-4 text-sm font-semibold" data-i18n="footer.contactCol">Kontak</h4>
        <ul class="space-y-3 text-xs text-white/75">
          <li><span data-i18n="footer.phone">Telepon</span>:
            <a href="tel:{{ $profil->no_telp_perusahaan ?? '085117494221' }}"
              class="hover:text-white">{{ $profil->no_telp_perusahaan ?? '085117494221' }}</a>
          </li>
          <li><span data-i18n="footer.email">Email</span>:
            <a href="mailto:{{ $profil->email_perusahaan ?? 'admin@firstudio.id' }}"
              class="hover:text-white">{{ $profil->email_perusahaan ?? 'admin@firstudio.id' }}</a>
          </li>
        </ul>
      </div>
      <div>
        <h4 class="mb-4 text-sm font-semibold" data-i18n="footer.addressCol">Alamat</h4>
        <p class="text-xs leading-relaxed text-white/75">
          @if ($profil && $profil->alamat_perusahaan)
            {!! nl2br(e($profil->alamat_perusahaan)) !!}
          @else
            Jl. Taman Lembayung No.47, Sendangguwo, Kec. Tembalang, Kota Semarang, Jawa Tengah (50273)
          @endif
        </p>
      </div>
    </div>
    <div
      class="mt-14 flex flex-col items-center gap-4 border-t border-white/15 pt-6 text-xs text-white/70 md:flex-row md:justify-between">
      <p>© {{ date('Y') }} {{ $profil->nama_perusahaan ?? 'Firstudio' }}. <span data-i18n="footer.rights">Hak cipta
          dilindungi.</span></p>
      <span class="flex items-center gap-2 text-sm font-bold tracking-wider text-white">
        <img src="{{ asset('web/assets/logo-white.png') }}" alt="" class="h-7 w-7 object-contain" />FIRSTUDIO
      </span>
      <div class="flex flex-wrap justify-center gap-5 md:justify-end">
        <a href="#" class="hover:text-white" data-i18n="footer.privacy">Kebijakan Privasi</a>
        <a href="#" class="hover:text-white" data-i18n="footer.terms">Syarat Layanan</a>
        <a href="#" class="hover:text-white" data-i18n="footer.cookies">Pengaturan Cookie</a>
      </div>
    </div>
  </div>
</footer>
