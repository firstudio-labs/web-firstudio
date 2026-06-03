@extends('template_web.layout')

@section('content')
 <!-- Hero Section -->
 <section class="hero-section bg-black px-6 py-20 text-white">
      <div class="mx-auto w-full max-w-6xl">
        <div class="flex flex-col items-center gap-12 lg:flex-row">
          <!-- Left Content -->
          <div class="flex-1 space-y-8">
            <div class="inline-block rounded-full border border-purple-500/30 bg-purple-500/10 px-4 py-2">
              <span class="text-sm font-semibold text-purple-400" data-i18n="nav.svc.mobile.title">Mobile App Development</span>
            </div>
            <h1 class="font-primary text-4xl font-bold leading-tight md:text-5xl lg:text-6xl" data-i18n="layanan.mobile.hero.h1">
              Kembangkan Aplikasi Mobile untuk Bisnis Anda
            </h1>
            <p class="font-secondary text-lg leading-relaxed text-white/80" data-i18n="layanan.mobile.hero.subtitle">
              Kami mengembangkan aplikasi mobile native dan cross-platform yang powerful, user-friendly, dan scalable. Dari iOS hingga Android, kami siap mewujudkan ide aplikasi Anda menjadi kenyataan dengan teknologi terkini seperti Flutter, React Native, dan native development.
            </p>
            <div class="btn-group">
              <a href="#process" class="btn btn-primary" data-i18n="layanan.common.hero.cta.process">Pelajari Prosesnya</a>
            </div>
          </div>

          <!-- Right Image -->
          <div class="flex-1">
            <div class="relative w-full" style="aspect-ratio: 16/10;">
              <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-purple-500/20 to-pink-500/20 blur-3xl"></div>
              <img 
                src="{{ asset('web/assets/layanan/mobile.png') }}" 
                alt="Mobile App Development" 
                class="relative z-10 h-full w-full object-cover rounded-3xl border border-white/10 shadow-2xl"
              >
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Process Section -->
    <section id="process" class="bg-gray-50 px-6 py-20 text-gray-900">
      <div class="mx-auto w-full max-w-6xl space-y-12">
        <div class="text-center space-y-4">
          <h2 class="font-primary text-3xl font-bold md:text-4xl" data-i18n="layanan.common.process.title">
            Proses Pengerjaan
          </h2>
          <p class="font-secondary text-lg text-gray-600 max-w-2xl mx-auto" data-i18n="layanan.common.process.subtitle">
            Kami mengikuti metodologi terstruktur untuk memastikan proyek Anda selesai tepat waktu dengan kualitas terbaik
          </p>
        </div>

        <div class="process-grid">
          <!-- Step 1 -->
          <div class="process-card">
            <div class="process-card__step">1</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.mobile.process.step1.title">Konsultasi & Discovery</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.mobile.process.step1.desc">
              Kami menganalisis kebutuhan bisnis Anda, menentukan platform (iOS, Android, atau cross-platform), dan merencanakan arsitektur aplikasi yang optimal.
            </p>
          </div>

          <!-- Step 2 -->
          <div class="process-card">
            <div class="process-card__step">2</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.mobile.process.step2.title">UI/UX Design</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.mobile.process.step2.desc">
              Tim desainer kami membuat mockup dan prototype yang user-friendly dengan fokus pada pengalaman pengguna yang optimal di berbagai ukuran layar.
            </p>
          </div>

          <!-- Step 3 -->
          <div class="process-card">
            <div class="process-card__step">3</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.mobile.process.step3.title">Development</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.mobile.process.step3.desc">
              Pengembangan aplikasi menggunakan teknologi modern seperti Flutter, React Native, Swift, atau Kotlin sesuai kebutuhan proyek Anda.
            </p>
          </div>

          <!-- Step 4 -->
          <div class="process-card">
            <div class="process-card__step">4</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.mobile.process.step4.title">Testing & QA</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.mobile.process.step4.desc">
              Pengujian menyeluruh di berbagai device dan versi OS untuk memastikan aplikasi berfungsi sempurna tanpa bug.
            </p>
          </div>

          <!-- Step 5 -->
          <div class="process-card">
            <div class="process-card__step">5</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.mobile.process.step5.title">App Store Submission</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.mobile.process.step5.desc">
              Aplikasi di-submit ke App Store (iOS) dan Google Play Store (Android) dengan optimasi metadata dan screenshots untuk visibilitas maksimal.
            </p>
          </div>

          <!-- Step 6 -->
          <div class="process-card">
            <div class="process-card__step">6</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.mobile.process.step6.title">Maintenance & Updates</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.mobile.process.step6.desc">
              Dukungan teknis berkelanjutan, update fitur, dan pemeliharaan rutin untuk memastikan aplikasi selalu kompatibel dengan versi OS terbaru.
            </p>
          </div>
        </div>
      </div>
    </section>


    <!-- CTA Section -->
    <section class="cta-section cta-section--dark px-6 py-20">
      <div class="mx-auto w-full max-w-4xl">
        <div class="cta-content">
          <h2 class="font-primary text-3xl font-bold md:text-4xl lg:text-5xl" data-i18n="layanan.mobile.cta.title">
            Siap Mengembangkan Aplikasi Mobile Anda?
          </h2>
          <p class="font-secondary text-lg text-white/80" data-i18n="layanan.mobile.cta.subtitle">
            Konsultasikan kebutuhan aplikasi mobile Anda dengan tim profesional kami. Dapatkan solusi terbaik untuk mengembangkan bisnis digital Anda melalui aplikasi mobile.
          </p>
          <div class="cta-actions">
            <a href="https://wa.me/6285117494221" target="_blank" class="btn btn-primary" data-i18n="layanan.cta.consult">Konsultasi Gratis</a>
            <a href="https://wa.me/6285117494221" target="_blank" class="btn btn-secondary" data-i18n="layanan.cta.whatsapp">WhatsApp Kami</a>
          </div>
        </div>
      </div>
    </section>
  @include('components.web.faq-section', [
    'subtitleKey' => 'faq.subtitle.mobile',
    'items' => [
      ['questionKey' => 'faq.mobile.q1', 'answerKey' => 'faq.mobile.a1'],
      ['questionKey' => 'faq.mobile.q2', 'answerKey' => 'faq.mobile.a2'],
      ['questionKey' => 'faq.mobile.q3', 'answerKey' => 'faq.mobile.a3'],
      ['questionKey' => 'faq.mobile.q4', 'answerKey' => 'faq.mobile.a4'],
      ['questionKey' => 'faq.mobile.q5', 'answerKey' => 'faq.mobile.a5'],
      ['questionKey' => 'faq.mobile.q6', 'answerKey' => 'faq.mobile.a6'],
    ],
  ])
@endsection 