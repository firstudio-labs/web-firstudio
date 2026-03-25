@extends('template_web.layout')

@section('content')
 <!-- Hero Section -->
 <section class="hero-section bg-black px-6 py-20 text-white">
      <div class="mx-auto w-full max-w-6xl">
        <div class="flex flex-col items-center gap-12 lg:flex-row">
          <!-- Left Content -->
          <div class="flex-1 space-y-8">
            <div class="inline-block rounded-full border border-purple-500/30 bg-purple-500/10 px-4 py-2">
              <span class="text-sm font-semibold text-purple-400">Mobile App Development</span>
            </div>
            <h1 class="font-primary text-4xl font-bold leading-tight md:text-5xl lg:text-6xl">
              Kembangkan Aplikasi Mobile untuk Bisnis Anda
            </h1>
            <p class="font-secondary text-lg leading-relaxed text-white/80">
              Kami mengembangkan aplikasi mobile native dan cross-platform yang powerful, user-friendly, dan scalable. Dari iOS hingga Android, kami siap mewujudkan ide aplikasi Anda menjadi kenyataan dengan teknologi terkini seperti Flutter, React Native, dan native development.
            </p>
            <div class="btn-group">
              <a href="#process" class="btn btn-primary">Pelajari Prosesnya</a>
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
              Kami menganalisis kebutuhan bisnis Anda, menentukan platform (iOS, Android, atau cross-platform), dan merencanakan arsitektur aplikasi yang optimal.
            </p>
          </div>

          <!-- Step 2 -->
          <div class="process-card">
            <div class="process-card__step">2</div>
            <h3 class="mb-4 text-xl font-bold">UI/UX Design</h3>
            <p class="text-gray-600 leading-relaxed">
              Tim desainer kami membuat mockup dan prototype yang user-friendly dengan fokus pada pengalaman pengguna yang optimal di berbagai ukuran layar.
            </p>
          </div>

          <!-- Step 3 -->
          <div class="process-card">
            <div class="process-card__step">3</div>
            <h3 class="mb-4 text-xl font-bold">Development</h3>
            <p class="text-gray-600 leading-relaxed">
              Pengembangan aplikasi menggunakan teknologi modern seperti Flutter, React Native, Swift, atau Kotlin sesuai kebutuhan proyek Anda.
            </p>
          </div>

          <!-- Step 4 -->
          <div class="process-card">
            <div class="process-card__step">4</div>
            <h3 class="mb-4 text-xl font-bold">Testing & QA</h3>
            <p class="text-gray-600 leading-relaxed">
              Pengujian menyeluruh di berbagai device dan versi OS untuk memastikan aplikasi berfungsi sempurna tanpa bug.
            </p>
          </div>

          <!-- Step 5 -->
          <div class="process-card">
            <div class="process-card__step">5</div>
            <h3 class="mb-4 text-xl font-bold">App Store Submission</h3>
            <p class="text-gray-600 leading-relaxed">
              Aplikasi di-submit ke App Store (iOS) dan Google Play Store (Android) dengan optimasi metadata dan screenshots untuk visibilitas maksimal.
            </p>
          </div>

          <!-- Step 6 -->
          <div class="process-card">
            <div class="process-card__step">6</div>
            <h3 class="mb-4 text-xl font-bold">Maintenance & Updates</h3>
            <p class="text-gray-600 leading-relaxed">
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
          <h2 class="font-primary text-3xl font-bold md:text-4xl lg:text-5xl">
            Siap Mengembangkan Aplikasi Mobile Anda?
          </h2>
          <p class="font-secondary text-lg text-white/80">
            Konsultasikan kebutuhan aplikasi mobile Anda dengan tim profesional kami. Dapatkan solusi terbaik untuk mengembangkan bisnis digital Anda melalui aplikasi mobile.
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
            Pertanyaan yang sering diajukan tentang layanan mobile app development kami
          </p>
        </div>

        <div class="space-y-4">
          <!-- FAQ 1 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="1"
            >
              <span class="font-semibold text-lg">Berapa lama waktu pengerjaan aplikasi mobile?</span>
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
                Waktu pengerjaan bervariasi tergantung kompleksitas proyek. Untuk paket Lite biasanya 6-8 minggu, paket Pro 10-12 minggu, dan paket X 16-20 minggu. Kami akan memberikan timeline detail setelah konsultasi awal.
              </p>
            </div>
          </div>

          <!-- FAQ 2 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="2"
            >
              <span class="font-semibold text-lg">Apakah aplikasi bisa di-update setelah launch?</span>
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
                Ya, tentu! Setiap paket sudah termasuk update dan revisi. Paket Lite mendapat 2x update, paket Pro 4x update, dan paket X unlimited update selama periode support. Update dilakukan melalui App Store dan Google Play Store.
              </p>
            </div>
          </div>

          <!-- FAQ 3 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="3"
            >
              <span class="font-semibold text-lg">Apakah harga sudah termasuk biaya App Store submission?</span>
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
                Harga yang tertera adalah untuk jasa pembuatan aplikasi saja. Biaya App Store submission (Apple Developer Program $99/tahun dan Google Play $25 sekali bayar) dibeli terpisah. Namun kami akan membantu proses submission dan setup akun developer.
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
                Sistem pembayaran dibagi 3 tahap: 30% DP di awal, 40% setelah desain dan prototype disetujui, dan 30% sisanya setelah aplikasi selesai dan siap di-submit ke App Store. Kami menerima transfer bank, e-wallet, dan virtual account.
              </p>
            </div>
          </div>

          <!-- FAQ 5 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="5"
            >
              <span class="font-semibold text-lg">Aplikasi bisa digunakan untuk iOS dan Android?</span>
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
                Ya! Semua paket kami menggunakan teknologi cross-platform (Flutter atau React Native) sehingga aplikasi bisa berjalan di iOS dan Android dengan satu codebase. Ini lebih efisien dan hemat biaya dibandingkan membuat aplikasi terpisah untuk setiap platform.
              </p>
            </div>
          </div>

          <!-- FAQ 6 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="6"
            >
              <span class="font-semibold text-lg">Bagaimana dengan maintenance setelah aplikasi launch?</span>
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
                Setiap paket sudah include support/maintenance gratis sesuai durasi yang tertera. Setelah periode gratis berakhir, Anda bisa berlangganan maintenance plan mulai dari 1jt/bulan untuk update rutin, bug fixes, kompatibilitas dengan OS terbaru, dan technical support.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection 