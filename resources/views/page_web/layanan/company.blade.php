@extends('template_web.layout')

@section('content')
 <!-- Hero Section -->
 <section class="hero-section bg-black px-6 py-20 text-white">
      <div class="mx-auto w-full max-w-6xl">
        <div class="flex flex-col items-center gap-12 lg:flex-row">
          <!-- Left Content -->
          <div class="flex-1 space-y-8">
            <div class="inline-block rounded-full border border-blue-500/30 bg-blue-500/10 px-4 py-2">
              <span class="text-sm font-semibold text-blue-400">Company Profile</span>
            </div>
            <h1 class="font-primary text-4xl font-bold leading-tight md:text-5xl lg:text-6xl">
              Buat Company Profile Profesional untuk Bisnis Anda
            </h1>
            <p class="font-secondary text-lg leading-relaxed text-white/80">
              Kami membantu perusahaan menampilkan identitas dan kredibilitas bisnis yang responsif, aman, dan mudah dikelola. Dari company profile hingga sistem informasi khusus, kami siap mewujudkan kebutuhan digital Anda dengan teknologi terkini.
            </p>
            <div class="btn-group">
              <a href="#process" class="btn btn-primary">Pelajari Prosesnya</a>
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
          <h2 class="font-primary text-3xl font-bold md:text-4xl">
            Proses Pengerjaan
          </h2>
          <p class="font-secondary text-lg text-gray-600 max-w-2xl mx-auto">
            Kami mengikuti metodologi terstruktur untuk memastikan proyek Anda selesai tepat waktu dengan kualitas terbaik
          </p>
        </div>

        <div class="process-grid">
          <!-- Step 1 -->
          <div class="process-card">
            <div class="process-card__step">1</div>
            <h3 class="mb-4 text-xl font-bold">Konsultasi & Discovery</h3>
            <p class="text-gray-600 leading-relaxed">
              Kami mendengarkan kebutuhan bisnis Anda, menganalisis target audiens, dan merencanakan struktur website yang optimal.
            </p>
          </div>

          <!-- Step 2 -->
          <div class="process-card">
            <div class="process-card__step">2</div>
            <h3 class="mb-4 text-xl font-bold">Design & Wireframe</h3>
            <p class="text-gray-600 leading-relaxed">
              Tim desainer kami membuat mockup dan wireframe yang mencerminkan identitas brand Anda dengan UI/UX yang menarik.
            </p>
          </div>

          <!-- Step 3 -->
          <div class="process-card">
            <div class="process-card__step">3</div>
            <h3 class="mb-4 text-xl font-bold">Development</h3>
            <p class="text-gray-600 leading-relaxed">
              Pengembangan frontend dan backend menggunakan teknologi modern seperti Laravel, React, dan Node.js untuk performa optimal.
            </p>
          </div>

          <!-- Step 4 -->
          <div class="process-card">
            <div class="process-card__step">4</div>
            <h3 class="mb-4 text-xl font-bold">Testing & QA</h3>
            <p class="text-gray-600 leading-relaxed">
              Pengujian menyeluruh untuk memastikan website berfungsi sempurna di semua device dan browser populer.
            </p>
          </div>

          <!-- Step 5 -->
          <div class="process-card">
            <div class="process-card__step">5</div>
            <h3 class="mb-4 text-xl font-bold">Deploy & Launch</h3>
            <p class="text-gray-600 leading-relaxed">
              Website di-deploy ke server dengan konfigurasi optimal, SSL certificate, dan optimasi performa untuk kecepatan loading maksimal.
            </p>
          </div>

          <!-- Step 6 -->
          <div class="process-card">
            <div class="process-card__step">6</div>
            <h3 class="mb-4 text-xl font-bold">Maintenance & Support</h3>
            <p class="text-gray-600 leading-relaxed">
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
          <h2 class="font-primary text-3xl font-bold md:text-4xl lg:text-5xl">
            Siap Membuat Company Profile untuk Bisnis Anda?
          </h2>
          <p class="font-secondary text-lg text-white/80">
            Konsultasikan kebutuhan company profile Anda dengan tim profesional kami. Dapatkan solusi terbaik untuk meningkatkan brand awareness dan kredibilitas bisnis Anda.
          </p>
          <div class="cta-actions">
            <a href="https://wa.me/6285117494221" target="_blank" class="btn btn-primary">Konsultasi Gratis</a>
            <a href="https://wa.me/6285117494221" target="_blank" class="btn btn-secondary">WhatsApp Kami</a>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="bg-gray-50 px-6 py-20 text-gray-900">
      <div class="mx-auto w-full max-w-4xl space-y-12">
        <div class="text-center space-y-4">
          <h2 class="font-primary text-3xl font-bold md:text-4xl">
            Frequently Asked Questions
          </h2>
          <p class="font-secondary text-lg text-gray-600">
            Pertanyaan yang sering diajukan tentang layanan company profile kami
          </p>
        </div>

        <div class="space-y-4">
          <!-- FAQ 1 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="1"
            >
              <span class="font-semibold text-lg">Berapa lama waktu pengerjaan website?</span>
              <svg
                class="h-6 w-6 flex-shrink-0 text-gray-500 transition-transform duration-200"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
              <p class="text-gray-600 leading-relaxed">
                Waktu pengerjaan bervariasi tergantung kompleksitas proyek. Untuk paket Lite biasanya 2-3 minggu, paket Pro 4-6 minggu, dan paket X 8-12 minggu. Kami akan memberikan timeline detail setelah konsultasi awal.
              </p>
            </div>
          </div>

          <!-- FAQ 2 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="2"
            >
              <span class="font-semibold text-lg">Apakah saya bisa request revisi?</span>
              <svg
                class="h-6 w-6 flex-shrink-0 text-gray-500 transition-transform duration-200"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
              <p class="text-gray-600 leading-relaxed">
                Ya, tentu! Setiap paket sudah termasuk revisi. Paket Lite mendapat 2x revisi, paket Pro 4x revisi, dan paket X unlimited revisi. Revisi dilakukan pada tahap desain dan sebelum deploy final.
              </p>
            </div>
          </div>

          <!-- FAQ 3 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="3"
            >
              <span class="font-semibold text-lg">Apakah harga sudah termasuk domain dan hosting?</span>
              <svg
                class="h-6 w-6 flex-shrink-0 text-gray-500 transition-transform duration-200"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
              <p class="text-gray-600 leading-relaxed">
                Harga yang tertera adalah untuk jasa pembuatan website saja. Domain dan hosting dibeli terpisah. Namun kami akan membantu Anda memilih dan setup domain & hosting yang sesuai kebutuhan. Biaya domain sekitar 150rb-500rb/tahun dan hosting mulai dari 500rb/tahun.
              </p>
            </div>
          </div>

          <!-- FAQ 4 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="4"
            >
              <span class="font-semibold text-lg">Bagaimana sistem pembayarannya?</span>
              <svg
                class="h-6 w-6 flex-shrink-0 text-gray-500 transition-transform duration-200"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
              <p class="text-gray-600 leading-relaxed">
                Sistem pembayaran dibagi 3 tahap: 30% DP di awal, 40% setelah desain disetujui, dan 30% sisanya setelah website selesai dan siap launch. Kami menerima transfer bank, e-wallet, dan virtual account.
              </p>
            </div>
          </div>

          <!-- FAQ 5 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="5"
            >
              <span class="font-semibold text-lg">Apakah website bisa di-update sendiri?</span>
              <svg
                class="h-6 w-6 flex-shrink-0 text-gray-500 transition-transform duration-200"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
              <p class="text-gray-600 leading-relaxed">
                Ya! Untuk paket Pro dan X, kami menyediakan CMS (Content Management System) yang user-friendly sehingga Anda bisa update konten sendiri tanpa perlu coding. Kami juga memberikan training penggunaan CMS.
              </p>
            </div>
          </div>

          <!-- FAQ 6 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="6"
            >
              <span class="font-semibold text-lg">Bagaimana dengan maintenance setelah project selesai?</span>
              <svg
                class="h-6 w-6 flex-shrink-0 text-gray-500 transition-transform duration-200"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="faq-content hidden px-6 pb-6">
              <p class="text-gray-600 leading-relaxed">
                Setiap paket sudah include support/maintenance gratis sesuai durasi yang tertera. Setelah periode gratis berakhir, Anda bisa berlangganan maintenance plan mulai dari 500rb/bulan untuk update rutin, backup, dan technical support.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection 