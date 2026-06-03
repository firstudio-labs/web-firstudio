<!-- Hero Section -->
@extends('template_web.layout')

@section('content')
<section class="hero-section bg-black px-6 py-20 text-white">
      <div class="mx-auto w-full max-w-6xl">
        <div class="flex flex-col items-center gap-12 lg:flex-row">
          <!-- Left Content -->
          <div class="flex-1 space-y-8">
            <div class="inline-block rounded-full border border-purple-500/30 bg-purple-500/10 px-4 py-2">
              <span class="text-sm font-semibold text-purple-400" data-i18n="nav.svc.outsourcing.title">IT Outsourcing</span>
            </div>
            <h1 class="font-primary text-4xl font-bold leading-tight md:text-5xl lg:text-6xl" data-i18n="layanan.outsourcing.hero.h1">
              Tim Ekstensi Profesional untuk Proyek Anda
            </h1>
            <p class="font-secondary text-lg leading-relaxed text-white/80" data-i18n="layanan.outsourcing.hero.subtitle">
              Kami menyediakan tenaga spesialis IT terdedikasi mulai dari Software Developer hingga UI/UX Designer untuk mendukung kebutuhan spesifik perusahaan Anda. Skalakan tim Anda dengan mudah bersama kami.
            </p>
            <div class="btn-group">
              <a href="#process" class="btn btn-primary" data-i18n="layanan.common.hero.cta.process">Pelajari Prosesnya</a>
            </div>
          </div>

          <!-- Right Image -->
          <div class="flex-1">
            <div class="relative w-full" style="aspect-ratio: 16/10;">
              <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-orange-500/20 to-red-500/20 blur-3xl"></div>
              <img 
                src="{{ asset('web/assets/layanan/outsourcing.jpg') }}" 
                alt="IT Outsourcing" 
                class="relative z-10 h-full w-full object-cover rounded-3xl border border-white/10 shadow-2xl"
                onerror="this.src='{{ asset('web/assets/layanan/website.png') }}'"
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
          <h2 class="font-primary text-3xl font-bold md:text-4xl" data-i18n="layanan.outsourcing.process.title">
            Proses Outsourcing
          </h2>
          <p class="font-secondary text-lg text-gray-600 max-w-2xl mx-auto" data-i18n="layanan.outsourcing.process.subtitle">
            Kami mengikuti metodologi yang terstruktur dalam menyalurkan talent terbaik yang sesuai dengan budaya dan kebutuhan perusahaan Anda.
          </p>
        </div>

        <div class="process-grid">
          <!-- Step 1 -->
          <div class="process-card">
            <div class="process-card__step">1</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.outsourcing.process.step1.title">Identifikasi Kebutuhan</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.outsourcing.process.step1.desc">
              Kami berdiskusi untuk memahami secara spesifik requirement (skillset, pengalaman, dan durasi) yang Anda butuhkan untuk proyek tersebut.
            </p>
          </div>

          <div class="process-card">
            <div class="process-card__step">2</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.outsourcing.process.step2.title">Pencarian Talent</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.outsourcing.process.step2.desc">
              Tim kami memetakan talenta internal (in-house developer) maupun talenta luar (jika diperlukan) yang memiliki kualifikasi paling relevan.
            </p>
          </div>

          <div class="process-card">
            <div class="process-card__step">3</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.outsourcing.process.step3.title">Wawancara & Kesepakatan</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.outsourcing.process.step3.desc">
              Kandidat potensial disodorkan kepada Anda untuk assessment. Jika cocok, kita bahas kesepakatan kontrak kerja dan timeline proyek.
            </p>
          </div>

          <div class="process-card">
            <div class="process-card__step">4</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.outsourcing.process.step4.title">Onboarding</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.outsourcing.process.step4.desc">
              Kandidat melakukan onboarding di perusahaan Anda agar mereka cepat mengenal sistem dan alur kerja di mana mereka ditugaskan.
            </p>
          </div>

          <div class="process-card">
            <div class="process-card__step">5</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.outsourcing.process.step5.title">Mulai Bekerja</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.outsourcing.process.step5.desc">
              Talent IT outsourcing akan bekerja langsung dalam koordinasi tim internal Anda layaknya pegawai sendiri selama durasi kesepakatan.
            </p>
          </div>

          <div class="process-card">
            <div class="process-card__step">6</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.outsourcing.process.step6.title">Evaluasi & Reporting</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.outsourcing.process.step6.desc">
              Secara berkala kami meminta feedback evaluasi dari Anda, guna memastikan performa pekerja outsourcing selalu berada di standar tinggi.
            </p>
          </div>
        </div>
      </div>
    </section>


    <!-- CTA Section -->
    <section class="cta-section cta-section--dark px-6 py-20">
      <div class="mx-auto w-full max-w-4xl">
        <div class="cta-content">
          <h2 class="font-primary text-3xl font-bold md:text-4xl lg:text-5xl" data-i18n="layanan.outsourcing.cta.title">
            Siap Transformasi Digital Bisnis Anda?
          </h2>
          <p class="font-secondary text-lg text-white/80" data-i18n="layanan.outsourcing.cta.subtitle">
            Konsultasikan kebutuhan teknologi bisnis Anda dengan tim profesional kami. Dapatkan solusi IT terbaik untuk meningkatkan efisiensi dan produktivitas perusahaan Anda.
          </p>
          <div class="cta-actions">
            <a href="https://wa.me/6285117494221" target="_blank" class="btn btn-primary" data-i18n="layanan.cta.consult">Konsultasi Gratis</a>
            <a href="https://wa.me/6285117494221" target="_blank" class="btn btn-secondary" data-i18n="layanan.cta.whatsapp">WhatsApp Kami</a>
          </div>
        </div>
      </div>
    </section>
  @include('components.web.faq-section', [
    'subtitleKey' => 'faq.subtitle.outsourcing',
    'items' => [
      ['questionKey' => 'faq.outsourcing.q1', 'answerKey' => 'faq.outsourcing.a1'],
      ['questionKey' => 'faq.outsourcing.q2', 'answerKey' => 'faq.outsourcing.a2'],
      ['questionKey' => 'faq.outsourcing.q3', 'answerKey' => 'faq.outsourcing.a3'],
      ['questionKey' => 'faq.outsourcing.q4', 'answerKey' => 'faq.outsourcing.a4'],
      ['questionKey' => 'faq.outsourcing.q5', 'answerKey' => 'faq.outsourcing.a5'],
      ['questionKey' => 'faq.outsourcing.q6', 'answerKey' => 'faq.outsourcing.a6'],
    ],
  ])
@endsection