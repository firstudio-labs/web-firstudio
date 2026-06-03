<!-- Hero Section -->
@extends('template_web.layout')

@section('content')
<section class="hero-section bg-black px-6 py-20 text-white">
      <div class="mx-auto w-full max-w-6xl">
        <div class="flex flex-col items-center gap-12 lg:flex-row">
          <!-- Left Content -->
          <div class="flex-1 space-y-8">
            <div class="inline-block rounded-full border border-orange-500/30 bg-orange-500/10 px-4 py-2">
              <span class="text-sm font-semibold text-orange-400" data-i18n="nav.svc.itconsul.title">IT Consultation</span>
            </div>
            <h1 class="font-primary text-4xl font-bold leading-tight md:text-5xl lg:text-6xl" data-i18n="layanan.itconsul.hero.h1">
              Solusi Teknologi untuk Efisiensi Bisnis Anda
            </h1>
            <p class="font-secondary text-lg leading-relaxed text-white/80" data-i18n="layanan.itconsul.hero.subtitle">
              Kami memberikan saran dan solusi teknologi terkini untuk membantu perusahaan meningkatkan efisiensi dan produktivitas. Dari konsultasi teknologi hingga pengembangan sistem informasi, kami siap membantu transformasi digital bisnis Anda.
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
                src="{{ asset('web/assets/layanan/itconsul.png') }}" 
                alt="IT Consultation" 
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
          <h2 class="font-primary text-3xl font-bold md:text-4xl" data-i18n="layanan.itconsul.process.title">
            Proses Konsultasi
          </h2>
          <p class="font-secondary text-lg text-gray-600 max-w-2xl mx-auto" data-i18n="layanan.itconsul.process.subtitle">
            Kami mengikuti metodologi terstruktur untuk memberikan solusi teknologi yang tepat sasaran dan dapat diimplementasikan dengan efektif
          </p>
        </div>

        <div class="process-grid">
          <!-- Step 1 -->
          <div class="process-card">
            <div class="process-card__step">1</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.itconsul.process.step1.title">Analisis Kebutuhan</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.itconsul.process.step1.desc">
              Kami melakukan analisis mendalam terhadap kebutuhan bisnis Anda, proses kerja yang ada, dan tantangan teknologi yang dihadapi untuk memahami situasi saat ini.
            </p>
          </div>

          <!-- Step 2 -->
          <div class="process-card">
            <div class="process-card__step">2</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.itconsul.process.step2.title">Riset Teknologi</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.itconsul.process.step2.desc">
              Tim kami melakukan riset teknologi terkini yang relevan dengan kebutuhan bisnis Anda, membandingkan berbagai solusi, dan mengidentifikasi teknologi terbaik.
            </p>
          </div>

          <!-- Step 3 -->
          <div class="process-card">
            <div class="process-card__step">3</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.itconsul.process.step3.title">Rekomendasi Solusi</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.itconsul.process.step3.desc">
              Kami menyusun rekomendasi solusi teknologi yang disesuaikan dengan kebutuhan, budget, dan timeline bisnis Anda, termasuk roadmap implementasi.
            </p>
          </div>

          <!-- Step 4 -->
          <div class="process-card">
            <div class="process-card__step">4</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.itconsul.process.step4.title">Presentasi & Diskusi</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.itconsul.process.step4.desc">
              Kami mempresentasikan rekomendasi solusi secara detail, menjawab pertanyaan, dan melakukan diskusi untuk memastikan solusi sesuai dengan ekspektasi.
            </p>
          </div>

          <!-- Step 5 -->
          <div class="process-card">
            <div class="process-card__step">5</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.itconsul.process.step5.title">Dokumentasi</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.itconsul.process.step5.desc">
              Kami menyediakan dokumentasi lengkap berupa proposal teknis, spesifikasi sistem, dan panduan implementasi yang dapat digunakan sebagai referensi.
            </p>
          </div>

          <!-- Step 6 -->
          <div class="process-card">
            <div class="process-card__step">6</div>
            <h3 class="mb-4 text-xl font-bold" data-i18n="layanan.itconsul.process.step6.title">Follow-up & Support</h3>
            <p class="text-gray-600 leading-relaxed" data-i18n="layanan.itconsul.process.step6.desc">
              Kami memberikan dukungan follow-up untuk membantu implementasi solusi, menjawab pertanyaan teknis, dan memberikan guidance selama proses implementasi.
            </p>
          </div>
        </div>
      </div>
    </section>


    <!-- CTA Section -->
    <section class="cta-section cta-section--dark px-6 py-20">
      <div class="mx-auto w-full max-w-4xl">
        <div class="cta-content">
          <h2 class="font-primary text-3xl font-bold md:text-4xl lg:text-5xl" data-i18n="layanan.itconsul.cta.title">
            Siap Transformasi Digital Bisnis Anda?
          </h2>
          <p class="font-secondary text-lg text-white/80" data-i18n="layanan.itconsul.cta.subtitle">
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
    'subtitleKey' => 'faq.subtitle.itconsul',
    'items' => [
      ['questionKey' => 'faq.itconsul.q1', 'answerKey' => 'faq.itconsul.a1'],
      ['questionKey' => 'faq.itconsul.q2', 'answerKey' => 'faq.itconsul.a2'],
      ['questionKey' => 'faq.itconsul.q3', 'answerKey' => 'faq.itconsul.a3'],
      ['questionKey' => 'faq.itconsul.q4', 'answerKey' => 'faq.itconsul.a4'],
      ['questionKey' => 'faq.itconsul.q5', 'answerKey' => 'faq.itconsul.a5'],
      ['questionKey' => 'faq.itconsul.q6', 'answerKey' => 'faq.itconsul.a6'],
    ],
  ])
@endsection