@extends('template_web.layout')

@section('content')
 <!-- Hero Section -->
 <section class="hero-section bg-black px-6 py-20 text-white">
      <div class="mx-auto w-full max-w-6xl">
        <div class="flex flex-col items-center gap-12 lg:flex-row">
          <!-- Left Content -->
          <div class="flex-1 space-y-8">
            <div class="inline-block rounded-full border border-blue-500/30 bg-blue-500/10 px-4 py-2">
              <span class="text-sm font-semibold text-blue-400">Website Development</span>
            </div>
            <h1 class="font-primary text-4xl font-bold leading-tight md:text-5xl lg:text-6xl">
              Bangun Website Profesional untuk Bisnis Anda
            </h1>
            <p class="font-secondary text-lg leading-relaxed text-white/80">
              Kami merancang dan membangun website yang responsif, aman, dan mudah dikelola. Dari company profile hingga sistem informasi khusus, kami siap mewujudkan kebutuhan digital Anda dengan teknologi terkini.
            </p>
            <div class="btn-group">
              <a href="#process" class="btn btn-primary">Pelajari Prosesnya</a>
            </div>
          </div>

          <!-- Right Image -->
          <div class="flex-1">
            <div class="relative">
              <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-blue-500/20 to-purple-500/20 blur-3xl"></div>
              <img 
                src="{{ asset('web/assets/layanan/website.png') }}" 
                alt="Website Development" 
                class="relative z-10 w-full rounded-3xl border border-white/10 shadow-2xl"
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

     <!-- Domain Check Section -->
     <section id="domain-check" class="bg-white px-6 py-20 text-gray-900">
        <div class="mx-auto w-full max-w-6xl space-y-12">
            <div class="text-center space-y-4">
                <div class="inline-block rounded-full border border-blue-500/30 bg-blue-500/10 px-4 py-2">
                    <span class="text-sm font-semibold text-blue-400" data-lang-id="domain-section-tag">CEK NAMA DOMAIN</span>
                </div>
                <h2 class="font-primary text-3xl font-bold md:text-4xl" data-lang-id="domain-section-title">Cari & Cek Ketersediaan Domain</h2>
                <p class="font-secondary text-lg text-gray-600 max-w-2xl mx-auto" data-lang-id="domain-section-desc">Masukkan nama domain yang Anda inginkan lalu pilih ekstensi (TLD). Kami akan mengecek ketersediaannya secara real-time.</p>
            </div>

            <div class="rounded-[32px] border border-gray-200 bg-white p-8 shadow-lg">
                <form id="domain-form" class="space-y-6">
                    <div>
                        <label for="domain-name" class="sr-only" data-lang-id="domain-name-label">Nama Domain</label>
                        <div class="relative">
                            <i data-lucide="globe" class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
                            <input id="domain-name" type="text" placeholder="contoh: namabisnis.com" class="w-full rounded-2xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 pl-12 pr-4 py-3.5 placeholder-gray-400 font-secondary" required data-lang-id="domain-name-placeholder" data-placeholder="true">
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <button id="check-domain-btn" type="submit" class="btn btn-primary">
                            <i data-lucide="search" class="w-5 h-5 mr-2"></i>
                            <span data-lang-id="domain-check-btn">Cek Ketersediaan</span>
                        </button>
                        <button id="clear-domain-btn" type="button" class="btn btn-secondary">
                            <i data-lucide="x-circle" class="w-5 h-5 mr-2"></i>
                            <span data-lang-id="domain-clear-btn">Bersihkan</span>
                        </button>
                    </div>
                </form>

                <div id="domain-result" class="mt-8 hidden">
                    <div id="domain-status-card" class="rounded-2xl p-6 border"></div>
                    <div id="domain-suggestions" class="mt-6"></div>
                </div>
            </div>

            <!-- Popular TLD Pricing -->
            <div class="space-y-4">
                <h3 class="font-primary text-xl font-semibold text-gray-900" data-lang-id="domain-pricing-title">Harga Domain Populer (per tahun)</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-5 py-4 shadow-sm">
                        <span class="font-secondary font-semibold text-gray-900">.com</span>
                        <span class="font-secondary text-sm text-gray-600" data-lang-id="domain-price-com">Rp. 185.000/thn</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-5 py-4 shadow-sm">
                        <span class="font-secondary font-semibold text-gray-900">.co.id</span>
                        <span class="font-secondary text-sm text-gray-600" data-lang-id="domain-price-coid">Rp. 300.000/thn</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-5 py-4 shadow-sm">
                        <span class="font-secondary font-semibold text-gray-900">.id</span>
                        <span class="font-secondary text-sm text-gray-600" data-lang-id="domain-price-id">Rp. 129.000/thn</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl border border-gray-200 bg-white px-5 py-4 shadow-sm">
                        <span class="font-secondary font-semibold text-gray-900">.co</span>
                        <span class="font-secondary text-sm text-gray-600" data-lang-id="domain-price-co">Rp. 450.000/thn</span>
                    </div>
                </div>
            </div>

            <p class="font-secondary text-xs text-gray-400 text-center" data-lang-id="domain-data-source">Sumber data: RDAP & DNS Google • Hasil hanya indikatif, ketersediaan final mengikuti registrar.</p>
        </div>
     </section>

    <!-- CTA Section -->
    <section class="cta-section cta-section--dark px-6 py-20">
      <div class="mx-auto w-full max-w-4xl">
        <div class="cta-content">
          <h2 class="font-primary text-3xl font-bold md:text-4xl lg:text-5xl">
            Siap Memulai Proyek Website Anda?
          </h2>
          <p class="font-secondary text-lg text-white/80">
            Konsultasikan kebutuhan website Anda dengan tim profesional kami. Dapatkan solusi terbaik untuk mengembangkan bisnis digital Anda.
          </p>
          <div class="cta-actions">
            <a href="https://wa.me/" target="_blank" class="btn btn-primary">Konsultasi Gratis</a>
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
            Pertanyaan yang sering diajukan tentang layanan website development kami
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

@section('script')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    // Initialize Lucide Icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // --- Domain Check Logic ---
    const domainForm = document.getElementById('domain-form');
    const domainInput = document.getElementById('domain-name');
    const domainResult = document.getElementById('domain-result');
    const domainStatusCard = document.getElementById('domain-status-card');
    const domainSuggestions = document.getElementById('domain-suggestions');
    const clearBtn = document.getElementById('clear-domain-btn');

    function normalizeDomainInput(raw) {
        const trimmed = raw.trim().toLowerCase();
        // Hilangkan skema & path jika pengguna menempel URL penuh
        try {
            const u = new URL(trimmed.includes('://') ? trimmed : `http://${trimmed}`);
            return u.hostname;
        } catch (e) {
            return trimmed.replace(/^https?:\/\//, '').split('/')[0];
        }
    }

    function renderStatus({ fqdn, available, source, whois, error }) {
        const icon = available ? 'check' : 'x';
        const iconColorClass = available ? 'text-green-600' : 'text-red-600';
        const bg = available ? 'bg-green-50' : 'bg-red-50';
        const border = available ? 'border-green-200' : 'border-red-200';
        const title = available ? 'Domain Tersedia' : 'Domain Sudah Terpakai';
        const desc = available 
            ? `Selamat! Domain ${fqdn} tersedia untuk didaftarkan.` 
            : `Maaf, domain ${fqdn} sudah terdaftar.`;

        domainStatusCard.className = `rounded-2xl p-6 border ${bg} ${border}`;
        domainStatusCard.innerHTML = `
            <div class="flex flex-col md:flex-row md:items-start gap-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center bg-white border-2 flex-shrink-0">
                    <i data-lucide="${icon}" class="w-6 h-6 ${iconColorClass}"></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-primary text-xl font-bold text-gray-900">${title}</h4>
                    <p class="font-secondary text-gray-700 mt-2">${desc}</p>
                    <p class="font-secondary text-xs text-gray-400 mt-2">Sumber: ${source}${error ? ` • Error: ${error}` : ''}</p>
                </div>
                <a href="{{ route('web.contact.index') }}" class="btn btn-primary flex-shrink-0">
                    <i data-lucide="message-square" class="w-4 h-4 mr-2"></i>
                    Konsultasi Beli Domain
                </a>
            </div>
        `;

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function renderSuggestions(baseLabel) {
        const ideas = [
            `${baseLabel}id`,
            `${baseLabel}indo`,
            `${baseLabel}digital`,
            `go-${baseLabel}`,
            `${baseLabel}-official`,
            `${baseLabel}studio`
        ];

        const tlds = ['.com', '.id', '.co.id', '.my.id'];
        const list = [];
        ideas.forEach(label => tlds.forEach(tld => list.push(`${label}${tld}`)));

        domainSuggestions.innerHTML = `
            <h5 class="font-primary text-base font-semibold text-gray-900 mb-4">Alternatif Nama Domain</h5>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                ${list.map(name => `<span class="font-secondary px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm text-gray-700 hover:border-blue-500 hover:text-blue-600 transition">${name}</span>`).join('')}
            </div>
        `;
    }

    async function checkViaRDAP(fqdn) {
        try {
            // rdap.org akan meneruskan ke RDAP registry terkait
            const url = `https://rdap.org/domain/${encodeURIComponent(fqdn)}`;
            const res = await fetch(url, { 
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            if (res.status === 404) {
                return { available: true, source: 'RDAP', whois: null };
            }
            if (!res.ok) {
                throw new Error(`RDAP ${res.status}`);
            }
            const data = await res.json();
            // Jika RDAP mengembalikan objek domain, anggap terdaftar
            return { available: false, source: 'RDAP', whois: data };
        } catch (error) {
            throw error;
        }
    }

    async function checkViaDNS(fqdn) {
        try {
            // Jika A/AAAA/CNAME/NS ada, kemungkinan domain aktif (terdaftar)
            const url = `https://dns.google/resolve?name=${encodeURIComponent(fqdn)}&type=A`;
            const res = await fetch(url, { 
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });
            
            if (!res.ok) {
                throw new Error(`DNS ${res.status}`);
            }
            const data = await res.json();
            const hasAnswer = Array.isArray(data.Answer) && data.Answer.length > 0;
            return { available: !hasAnswer, source: 'DNS Google', whois: null };
        } catch (error) {
            throw error;
        }
    }

    async function checkDomainAvailability(fqdn) {
        try {
            return await checkViaRDAP(fqdn);
        } catch (e) {
            try {
                return await checkViaDNS(fqdn);
            } catch (e2) {
                return { 
                    available: false, 
                    source: 'RDAP/DNS', 
                    whois: null, 
                    error: e2.message || 'Tidak dapat memeriksa ketersediaan domain' 
                };
            }
        }
    }

    if (domainForm) {
        domainForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const fqdn = normalizeDomainInput(domainInput.value);
            
            if (!fqdn || !fqdn.includes('.')) {
                alert('Masukkan nama domain yang valid (contoh: namabisnis.com)');
                domainInput.focus();
                return;
            }

            domainResult.classList.remove('hidden');
            domainStatusCard.className = 'rounded-2xl p-6 border bg-yellow-50 border-yellow-200';
            domainStatusCard.innerHTML = `
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-white border-2 flex-shrink-0">
                        <svg class="w-6 h-6 text-yellow-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-primary text-xl font-bold text-gray-900">Memeriksa Ketersediaan…</h4>
                        <p class="font-secondary text-gray-700 mt-2">${fqdn}</p>
                        <p class="font-secondary text-xs text-gray-400 mt-2">Menggunakan RDAP & DNS Google</p>
                    </div>
                </div>
            `;
            domainSuggestions.innerHTML = '';
            
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            try {
                const result = await checkDomainAvailability(fqdn);
                const baseLabel = fqdn.split('.')[0].replace(/[^a-z0-9-]/g, '');
                renderStatus({ fqdn, ...result });
                
                if (baseLabel && result.available === false) {
                    renderSuggestions(baseLabel);
                } else {
                    domainSuggestions.innerHTML = '';
                }
            } catch (error) {
                domainStatusCard.className = 'rounded-2xl p-6 border bg-red-50 border-red-200';
                domainStatusCard.innerHTML = `
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center bg-white border-2 flex-shrink-0">
                            <i data-lucide="alert-circle" class="w-6 h-6 text-red-600"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-primary text-xl font-bold text-gray-900">Terjadi Kesalahan</h4>
                            <p class="font-secondary text-gray-700 mt-2">Tidak dapat memeriksa ketersediaan domain. Silakan coba lagi atau hubungi kami untuk bantuan.</p>
                            <p class="font-secondary text-xs text-gray-400 mt-2">Error: ${error.message || 'Unknown error'}</p>
                        </div>
                    </div>
                `;
                
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            domainInput.value = '';
            domainResult.classList.add('hidden');
            domainStatusCard.innerHTML = '';
            domainSuggestions.innerHTML = '';
            domainInput.focus();
        });
    }
</script>
@endsection