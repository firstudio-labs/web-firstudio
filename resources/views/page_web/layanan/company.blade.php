@extends('template_web.layout')

@section('content')
 <!-- Hero Section -->
 <section class="hero-section bg-black px-6 py-20 text-white">
      <div class="mx-auto w-full max-w-6xl">
        <div class="flex flex-col items-center gap-12 lg:flex-row">
          <!-- Left Content -->
          <div class="flex-1 space-y-8">
            <div class="inline-block rounded-full border border-blue-500/30 bg-blue-500/10 px-4 py-2">
              <span class="text-sm font-semibold text-blue-400" data-i18n="nav.svc.company.title">Company Profile</span>
            </div>
            <h1 class="font-primary text-4xl font-bold leading-tight md:text-5xl lg:text-6xl" data-i18n="layanan.company.hero.h1">
              Buat Company Profile Profesional untuk Bisnis Anda
            </h1>
            <p class="font-secondary text-lg leading-relaxed text-white/80" data-i18n="layanan.company.hero.subtitle">
              Kami membantu perusahaan menampilkan identitas dan kredibilitas bisnis yang responsif, aman, dan mudah dikelola. Dari company profile hingga sistem informasi khusus, kami siap mewujudkan kebutuhan digital Anda dengan teknologi terkini.
            </p>
            <div class="btn-group">
              <a href="#process" class="btn btn-primary" data-i18n="layanan.common.hero.cta.process">Pelajari Prosesnya</a>
            </div>
          </div>

          <!-- Right Image -->
          <div class="flex-1">
            <div class="relative w-full" style="aspect-ratio: 16/10;">
              <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-green-500/20 to-emerald-500/20 blur-3xl"></div>
              <img 
                src="{{ asset('web/assets/layanan/company.png') }}" 
                alt="Company Profile" 
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
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.company.process.step1.title">Konsultasi & Discovery</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.company.process.step1.desc">
              Kami mendengarkan kebutuhan bisnis Anda, menganalisis target audiens, dan merencanakan struktur website yang optimal.
            </p>
          </div>

          <!-- Step 2 -->
          <div class="process-card">
            <div class="process-card__step">2</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.company.process.step2.title">Design & Wireframe</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.company.process.step2.desc">
              Tim desainer kami membuat mockup dan wireframe yang mencerminkan identitas brand Anda dengan UI/UX yang menarik.
            </p>
          </div>

          <!-- Step 3 -->
          <div class="process-card">
            <div class="process-card__step">3</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.company.process.step3.title">Development</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.company.process.step3.desc">
              Pengembangan frontend dan backend menggunakan teknologi modern seperti Laravel, React, dan Node.js untuk performa optimal.
            </p>
          </div>

          <!-- Step 4 -->
          <div class="process-card">
            <div class="process-card__step">4</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.company.process.step4.title">Testing & QA</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.company.process.step4.desc">
              Pengujian menyeluruh untuk memastikan website berfungsi sempurna di semua device dan browser populer.
            </p>
          </div>

          <!-- Step 5 -->
          <div class="process-card">
            <div class="process-card__step">5</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.company.process.step5.title">Deploy & Launch</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.company.process.step5.desc">
              Website di-deploy ke server dengan konfigurasi optimal, SSL certificate, dan optimasi performa untuk kecepatan loading maksimal.
            </p>
          </div>

          <!-- Step 6 -->
          <div class="process-card">
            <div class="process-card__step">6</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.company.process.step6.title">Maintenance & Support</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.company.process.step6.desc">
              Dukungan teknis berkelanjutan, update konten, dan pemeliharaan rutin untuk memastikan website selalu optimal.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Pricing Section -->
    <!-- CTA Section -->
    <section class="cta-section cta-section--dark px-6 py-20">
      <div class="mx-auto w-full max-w-4xl">
        <div class="cta-content">
          <h2 class="font-primary text-3xl font-bold md:text-4xl lg:text-5xl" data-i18n="layanan.company.cta.title">
            Siap Membuat Company Profile untuk Bisnis Anda?
          </h2>
          <p class="font-secondary text-lg text-white/80" data-i18n="layanan.company.cta.subtitle">
            Konsultasikan kebutuhan company profile Anda dengan tim profesional kami. Dapatkan solusi terbaik untuk meningkatkan brand awareness dan kredibilitas bisnis Anda.
          </p>
          <div class="cta-actions">
            <a href="https://wa.me/6285117494221" target="_blank" class="btn btn-primary" data-i18n="layanan.cta.consult">Konsultasi Gratis</a>
            <a href="https://wa.me/6285117494221" target="_blank" class="btn btn-secondary" data-i18n="layanan.cta.whatsapp">WhatsApp Kami</a>
          </div>
        </div>
      </div>
    </section>
  @include('components.web.faq-section', [
    'subtitleKey' => 'faq.subtitle.company',
    'items' => [
      ['questionKey' => 'faq.company.q1', 'answerKey' => 'faq.company.a1'],
      ['questionKey' => 'faq.company.q2', 'answerKey' => 'faq.company.a2'],
      ['questionKey' => 'faq.company.q3', 'answerKey' => 'faq.company.a3'],
      ['questionKey' => 'faq.company.q4', 'answerKey' => 'faq.company.a4'],
      ['questionKey' => 'faq.company.q5', 'answerKey' => 'faq.company.a5'],
      ['questionKey' => 'faq.company.q6', 'answerKey' => 'faq.company.a6'],
    ],
  ])
@endsection 