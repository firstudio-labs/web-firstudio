<!-- Hero Section -->
@extends('template_web.layout')

@section('content')
<section class="hero-section bg-black px-6 py-20 text-white">
      <div class="mx-auto w-full max-w-6xl">
        <div class="flex flex-col items-center gap-12 lg:flex-row">
          <!-- Left Content -->
          <div class="flex-1 space-y-8">
            <div class="inline-block rounded-full border border-orange-500/30 bg-orange-500/10 px-4 py-2">
              <span class="text-sm font-semibold text-orange-400">IT Consultation</span>
            </div>
            <h1 class="font-primary text-4xl font-bold leading-tight md:text-5xl lg:text-6xl">
              Solusi Teknologi untuk Efisiensi Bisnis Anda
            </h1>
            <p class="font-secondary text-lg leading-relaxed text-white/80">
              Kami memberikan saran dan solusi teknologi terkini untuk membantu perusahaan meningkatkan efisiensi dan produktivitas. Dari konsultasi teknologi hingga pengembangan sistem informasi, kami siap membantu transformasi digital bisnis Anda.
            </p>
            <div class="btn-group">
              <a href="#pricing" class="btn btn-primary">Lihat Paket Konsultasi</a>
              <a href="#process" class="btn btn-secondary">Pelajari Prosesnya</a>
            </div>
          </div>

          <!-- Right Image -->
          <div class="flex-1">
            <div class="relative">
              <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-orange-500/20 to-red-500/20 blur-3xl"></div>
              <img 
                src="{{ asset('web/assets/layanan/itconsul.png') }}" 
                alt="IT Consultation" 
                class="relative z-10 w-full rounded-3xl border border-white/10 shadow-2xl"
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
            Proses Konsultasi
          </h2>
          <p class="font-secondary text-lg text-gray-600 max-w-2xl mx-auto">
            Kami mengikuti metodologi terstruktur untuk memberikan solusi teknologi yang tepat sasaran dan dapat diimplementasikan dengan efektif
          </p>
        </div>

        <div class="process-grid">
          <!-- Step 1 -->
          <div class="process-card">
            <div class="process-card__step">1</div>
            <h3 class="mb-4 text-xl font-bold">Analisis Kebutuhan</h3>
            <p class="text-gray-600 leading-relaxed">
              Kami melakukan analisis mendalam terhadap kebutuhan bisnis Anda, proses kerja yang ada, dan tantangan teknologi yang dihadapi untuk memahami situasi saat ini.
            </p>
          </div>

          <!-- Step 2 -->
          <div class="process-card">
            <div class="process-card__step">2</div>
            <h3 class="mb-4 text-xl font-bold">Riset Teknologi</h3>
            <p class="text-gray-600 leading-relaxed">
              Tim kami melakukan riset teknologi terkini yang relevan dengan kebutuhan bisnis Anda, membandingkan berbagai solusi, dan mengidentifikasi teknologi terbaik.
            </p>
          </div>

          <!-- Step 3 -->
          <div class="process-card">
            <div class="process-card__step">3</div>
            <h3 class="mb-4 text-xl font-bold">Rekomendasi Solusi</h3>
            <p class="text-gray-600 leading-relaxed">
              Kami menyusun rekomendasi solusi teknologi yang disesuaikan dengan kebutuhan, budget, dan timeline bisnis Anda, termasuk roadmap implementasi.
            </p>
          </div>

          <!-- Step 4 -->
          <div class="process-card">
            <div class="process-card__step">4</div>
            <h3 class="mb-4 text-xl font-bold">Presentasi & Diskusi</h3>
            <p class="text-gray-600 leading-relaxed">
              Kami mempresentasikan rekomendasi solusi secara detail, menjawab pertanyaan, dan melakukan diskusi untuk memastikan solusi sesuai dengan ekspektasi.
            </p>
          </div>

          <!-- Step 5 -->
          <div class="process-card">
            <div class="process-card__step">5</div>
            <h3 class="mb-4 text-xl font-bold">Dokumentasi</h3>
            <p class="text-gray-600 leading-relaxed">
              Kami menyediakan dokumentasi lengkap berupa proposal teknis, spesifikasi sistem, dan panduan implementasi yang dapat digunakan sebagai referensi.
            </p>
          </div>

          <!-- Step 6 -->
          <div class="process-card">
            <div class="process-card__step">6</div>
            <h3 class="mb-4 text-xl font-bold">Follow-up & Support</h3>
            <p class="text-gray-600 leading-relaxed">
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
          <h2 class="font-primary text-3xl font-bold md:text-4xl lg:text-5xl">
            Siap Transformasi Digital Bisnis Anda?
          </h2>
          <p class="font-secondary text-lg text-white/80">
            Konsultasikan kebutuhan teknologi bisnis Anda dengan tim profesional kami. Dapatkan solusi IT terbaik untuk meningkatkan efisiensi dan produktivitas perusahaan Anda.
          </p>
          <div class="cta-actions">
            <a href="{{ route('web.contact.index') }}" class="btn btn-primary">Konsultasi Gratis</a>
            <a href="https://wa.me/6285770333333" target="_blank" class="btn btn-secondary">WhatsApp Kami</a>
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
            Pertanyaan yang sering diajukan tentang layanan IT consultation kami
          </p>
        </div>

        <div class="space-y-4">
          <!-- FAQ 1 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="1"
            >
              <span class="font-semibold text-lg">Apa saja yang dibahas dalam konsultasi IT?</span>
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
                Konsultasi IT kami mencakup: analisis kebutuhan teknologi, rekomendasi solusi teknologi terkini, konsultasi penggunaan teknologi, konsultasi pengembangan sistem informasi, konsultasi pengembangan aplikasi mobile, dan roadmap implementasi. Topik dapat disesuaikan dengan kebutuhan spesifik bisnis Anda.
              </p>
            </div>
          </div>

          <!-- FAQ 2 -->
          <div class="rounded-2xl border border-gray-200 bg-white overflow-hidden">
            <button
              class="faq-button flex w-full items-center justify-between p-6 text-left transition hover:bg-gray-50"
              data-faq="2"
            >
              <span class="font-semibold text-lg">Berapa lama durasi konsultasi?</span>
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
                Durasi konsultasi bervariasi sesuai paket. Paket Basic: 2 jam, Paket Professional: 4-6 jam (dapat dibagi beberapa sesi), dan Paket Enterprise: intensif sesuai kebutuhan. Kami fleksibel dalam mengatur jadwal konsultasi yang sesuai dengan waktu Anda.
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