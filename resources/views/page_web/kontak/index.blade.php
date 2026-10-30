@extends('template_web.layout')

@section('content')
  <x-web.page-hero title="Ceritakan sistem yang Anda punya." title-i18n="rb.contact.hero.title" crumb="Kontak"
    crumb-i18n="nav.contact" eyebrow="Kontak" eyebrow-i18n="nav.contact"
    subtitle="Isi formulir atau hubungi kami langsung. Konsultasi awal gratis." subtitle-i18n="rb.contact.hero.desc" />

  <section class="rb-section rb-paper px-6 !pt-20">
    <div class="page-container grid items-start gap-8 lg:grid-cols-[1.85fr_1fr]">
      <div class="rb-card p-8 md:p-10">
        @if (session('success'))
          <div class="mb-6 border border-green-200 bg-green-50 p-3 text-sm text-green-700">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
          <ul class="mb-6 list-disc border border-red-200 bg-red-50 p-3 pl-8 text-sm text-red-700">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        @endif
        <h2 class="text-2xl font-semibold text-navy" data-i18n="contact.form.title">Kirim Pesan</h2>
        <p class="mt-2 max-w-lg text-xs leading-relaxed text-muted" data-i18n="rb.contact.form.desc">Ceritakan sistem yang
          Anda pakai sekarang dan apa yang ingin diperbaiki. Kami membalas di jam operasional.</p>
        <form action="{{ route('web.contact.store') }}" method="POST" class="rb-form mt-8 space-y-5">
          @csrf
          <div class="grid gap-5 sm:grid-cols-2">
            <div>
              <label class="mb-1.5 block text-xs font-medium text-navy" for="f-nama" data-i18n="contact.form.name">Nama Lengkap</label>
              <input id="f-nama" type="text" name="nama" required value="{{ old('nama') }}"
                data-i18n-placeholder="contact.placeholder.name" placeholder="Masukkan nama lengkap" />
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-medium text-navy" for="f-perusahaan" data-i18n="rb.contact.company">Perusahaan</label>
              <input id="f-perusahaan" type="text" name="perusahaan" value="{{ old('perusahaan') }}"
                data-i18n-placeholder="rb.contact.company.ph" placeholder="Nama perusahaan atau instansi" />
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-medium text-navy" for="f-email" data-i18n="rb.contact.email">Email Kerja</label>
              <input id="f-email" type="email" name="email" required value="{{ old('email') }}"
                data-i18n-placeholder="rb.contact.email.ph" placeholder="nama@perusahaan.com" />
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-medium text-navy" for="f-hp" data-i18n="contact.form.phone">Nomor Telepon</label>
              <input id="f-hp" type="tel" name="no_hp" required value="{{ old('no_hp') }}"
                data-i18n-placeholder="contact.placeholder.phone" placeholder="08xxxxxxxxxx" />
            </div>
          </div>
          <fieldset>
            <legend class="mb-2 text-xs font-medium text-navy" data-i18n="rb.contact.need">Yang Anda butuhkan</legend>
            <div class="flex flex-wrap gap-2">
              @foreach (['AI Integration', 'Sistem Web', 'Mobile Apps', 'Website', 'Belum yakin'] as $opsi)
                <label class="cursor-pointer">
                  <input type="checkbox" name="kebutuhan[]" value="{{ $opsi }}" class="peer sr-only"
                    @checked(in_array($opsi, old('kebutuhan', []))) />
                  <span class="rb-chip block peer-checked:border-brand peer-checked:bg-tint peer-checked:text-brand">{{ $opsi }}</span>
                </label>
              @endforeach
            </div>
          </fieldset>
          <div>
            <label class="mb-1.5 block text-xs font-medium text-navy" for="f-pesan" data-i18n="contact.form.message">Pesan</label>
            <textarea id="f-pesan" name="pesan" rows="5" required data-i18n-placeholder="rb.contact.message.ph"
              placeholder="Contoh: kami pakai ERP X dan ingin chatbot WhatsApp yang bisa cek status pesanan.">{{ old('pesan') }}</textarea>
          </div>
          <div class="flex flex-wrap items-center justify-between gap-4">
            @if (config('services.hcaptcha.site_key'))
              <div class="h-captcha" data-sitekey="{{ config('services.hcaptcha.site_key') }}"></div>
            @endif
            <button type="submit" class="rb-btn rb-btn--navy ml-auto" data-i18n="rb.contact.submit">Kirim Pesan</button>
          </div>
        </form>
      </div>

      <aside class="rb-dark p-8">
        <p class="rb-eyebrow" data-i18n="rb.contact.info">Informasi Kontak</p>
        <ul class="mt-6 divide-y divide-white/15 text-sm">
          <li class="py-4">
            <p class="rb-eyebrow !text-white/50" data-i18n="footer.phone">Telepon</p>
            <a href="tel:{{ $profil->no_telp_perusahaan ?? '085117494221' }}" class="mt-1 block">{{ $profil->no_telp_perusahaan ?? '085117494221' }}</a>
          </li>
          <li class="py-4">
            <p class="rb-eyebrow !text-white/50" data-i18n="footer.email">Email</p>
            <a href="mailto:{{ $profil->email_perusahaan ?? 'admin@firstudio.id' }}" class="mt-1 block">{{ $profil->email_perusahaan ?? 'admin@firstudio.id' }}</a>
          </li>
          <li class="py-4">
            <p class="rb-eyebrow !text-white/50" data-i18n="contact.info.hours">Jam Operasional</p>
            <p class="mt-1"><span data-i18n="rb.contact.hours1">Senin sampai Jumat, 09.00 sampai 18.00 WIB</span><br /><span data-i18n="rb.contact.hours2">Sabtu dan Minggu tutup</span></p>
          </li>
          <li class="py-4">
            <p class="rb-eyebrow !text-white/50" data-i18n="footer.addressCol">Alamat</p>
            <p class="mt-1 leading-relaxed">{!! nl2br(e($profil->alamat_perusahaan ?? 'Jl. Taman Lembayung No.47, Sendangguwo, Kec. Tembalang, Kota Semarang, Jawa Tengah 50273')) !!}</p>
          </li>
        </ul>
        <a href="https://wa.me/6285117494221" target="_blank" rel="noopener" class="rb-btn rb-btn--white mt-4 w-full"
          data-i18n="rb.contact.wa">Chat via WhatsApp</a>
      </aside>
    </div>
  </section>
@endsection

@section('script')
  @if (config('services.hcaptcha.site_key'))
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
  @endif
@endsection
