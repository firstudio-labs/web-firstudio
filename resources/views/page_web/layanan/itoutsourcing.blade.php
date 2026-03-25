<!-- Hero Section -->
@extends('template_web.layout')

@section('content')
<section class="hero-section bg-black px-6 py-20 text-white">
      <div class="mx-auto w-full max-w-6xl">
        <div class="flex flex-col items-center gap-12 lg:flex-row">
          <!-- Left Content -->
          <div class="flex-1 space-y-8">
            <div class="inline-block rounded-full border border-purple-500/30 bg-purple-500/10 px-4 py-2">
              <span class="text-sm font-semibold text-purple-400">IT Outsourcing</span>
            </div>
            <h1 class="font-primary text-4xl font-bold leading-tight md:text-5xl lg:text-6xl">
              Tim Ekstensi Profesional untuk Proyek Anda
            </h1>
            <p class="font-secondary text-lg leading-relaxed text-white/80">
              Kami menyediakan tenaga spesialis IT terdedikasi mulai dari Software Developer hingga UI/UX Designer untuk mendukung kebutuhan spesifik perusahaan Anda. Skalakan tim Anda dengan mudah bersama kami.
            </p>
            <div class="btn-group">
              <a href="#process" class="btn btn-primary">Pelajari Prosesnya</a>
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
          <h2 class="font-primary text-3xl font-bold md:text-4xl">
            Proses Outsourcing
          </h2>
          <p class="font-secondary text-lg text-gray-600 max-w-2xl mx-auto">
            Kami mengikuti metodologi yang terstruktur dalam menyalurkan talent terbaik yang sesuai dengan budaya dan kebutuhan perusahaan Anda.
          </p>
        </div>

        <div class="process-grid">
          <!-- Step 1 -->
          <div class="process-card">
            <div class="process-card__step">1</div>
            <h3 class="mb-4 text-xl font-bold">Identifikasi Kebutuhan</h3>
            <p class="text-gray-600 leading-relaxed">
              Kami berdiskusi untuk memahami secara spesifik requirement (skillset, pengalaman, dan durasi) yang Anda butuhkan untuk proyek tersebut.
            </p>
          </div>

          <div class="process-card">
            <div class="process-card__step">2</div>
            <h3 class="mb-4 text-xl font-bold">Pencarian Talent</h3>
            <p class="text-gray-600 leading-relaxed">
              Tim kami memetakan talenta internal (in-house developer) maupun talenta luar (jika diperlukan) yang memiliki kualifikasi paling relevan.
            </p>
          </div>

          <div class="process-card">
            <div class="process-card__step">3</div>
            <h3 class="mb-4 text-xl font-bold">Wawancara & Kesepakatan</h3>
            <p class="text-gray-600 leading-relaxed">
              Kandidat potensial disodorkan kepada Anda untuk assessment. Jika cocok, kita bahas kesepakatan kontrak kerja dan timeline proyek.
            </p>
          </div>

          <div class="process-card">
            <div class="process-card__step">4</div>
            <h3 class="mb-4 text-xl font-bold">Onboarding</h3>
            <p class="text-gray-600 leading-relaxed">
              Kandidat melakukan onboarding di perusahaan Anda agar mereka cepat mengenal sistem dan alur kerja di mana mereka ditugaskan.
            </p>
          </div>

          <div class="process-card">
            <div class="process-card__step">5</div>
            <h3 class="mb-4 text-xl font-bold">Mulai Bekerja</h3>
            <p class="text-gray-600 leading-relaxed">
              Talent IT outsourcing akan bekerja langsung dalam koordinasi tim internal Anda layaknya pegawai sendiri selama durasi kesepakatan.
            </p>
          </div>

          <div class="process-card">
            <div class="process-card__step">6</div>
            <h3 class="mb-4 text-xl font-bold">Evaluasi & Reporting</h3>
            <p class="text-gray-600 leading-relaxed">
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
          <h2 class="font-primary text-3xl font-bold md:text-4xl lg:text-5xl">
            Siap Transformasi Digital Bisnis Anda?
          </h2>
          <p class="font-secondary text-lg text-white/80">
            Konsultasikan kebutuhan teknologi bisnis Anda dengan tim profesional kami. Dapatkan solusi IT terbaik untuk meningkatkan efisiensi dan produktivitas perusahaan Anda.
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
            Pertanyaan yang sering diajukan tentang layanan IT Outsourcing kami
          </p>
        </div>

        <div class="space-y-4">
          <!-- FAQ 1 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="1"
            >
              <span class="font-semibold text-lg">Posisi IT apa saja yang tersedia untuk di-outsource?</span>
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
                Kami menyediakan berbagai posisi IT yang sering dibutuhkan industri, antara lain: Frontend Developer (React, Vue, dll), Backend Developer (Laravel, Node.js, dll), Mobile Developer (Flutter, React Native), UI/UX Designer, QA Engineer, DevOps, dan IT Project Manager.
              </p>
            </div>
          </div>

          <!-- FAQ 2 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="2"
            >
              <span class="font-semibold text-lg">Berapa minimal durasi kontrak untuk tim outsourcing?</span>
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
                Durasi minimal kontrak standar adalah 3 bulan. Kami merekomendasikan hal tersebut untuk memastikan talent bisa melakukan adaptasi dan fokus maksimal pada delivery project. Kami juga terbuka untuk negosiasi kontrak dalam jangka 6 bulan hingga 1 tahun menyesuaikan panjang ekspektasi produk.
              </p>
            </div>
          </div>

          <!-- FAQ 3 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="3"
            >
              <span class="font-semibold text-lg">Apakah konsultasi bisa dilakukan secara online?</span>
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
                Ya, konsultasi dapat dilakukan secara online (via Zoom/Google Meet) atau offline (onsite di kantor Anda). Kami menyesuaikan dengan preferensi dan kebutuhan Anda. Untuk konsultasi online, kami tetap memberikan pengalaman yang sama efektifnya dengan konsultasi offline.
              </p>
            </div>
          </div>

          <!-- FAQ 4 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="4"
            >
              <span class="font-semibold text-lg">Apakah saya akan mendapatkan dokumentasi setelah konsultasi?</span>
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
                Ya, setiap paket sudah termasuk dokumentasi. Paket Basic: dokumentasi ringkas, Paket Professional: dokumentasi lengkap termasuk proposal teknis dan roadmap, Paket Enterprise: dokumentasi enterprise (RFP, SOW, dll). Dokumentasi akan dikirimkan dalam format PDF setelah konsultasi selesai.
              </p>
            </div>
          </div>

          <!-- FAQ 5 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="5"
            >
              <span class="font-semibold text-lg">Apakah konsultasi termasuk implementasi solusi?</span>
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
                Konsultasi fokus pada analisis, rekomendasi, dan roadmap implementasi. Implementasi solusi merupakan layanan terpisah yang dapat dibahas setelah konsultasi. Namun, kami memberikan guidance dan support selama proses implementasi sesuai paket yang dipilih.
              </p>
            </div>
          </div>

          <!-- FAQ 6 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="6"
            >
              <span class="font-semibold text-lg">Bagaimana sistem pembayaran untuk konsultasi?</span>
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
                Untuk paket Basic: pembayaran penuh di awal. Paket Professional: 50% DP di awal, 50% setelah konsultasi selesai. Paket Enterprise: pembayaran dapat dinegosiasikan sesuai scope proyek. Kami menerima transfer bank, e-wallet, dan virtual account.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection