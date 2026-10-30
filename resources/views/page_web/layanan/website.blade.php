@extends('template_web.layout')

@section('content')
  <x-web.layanan-hero title-key="layanan.website.hero.h1" default-title="Pembuatan Website Terintegrasi AI" />

  <!-- Service Options Section -->
  <section id="layanan-detail" class="rb-section rb-paper px-6 text-ink">
    <div class="mx-auto w-full max-w-[80rem] space-y-12">
      <div class="space-y-4">
        <h2 class="rb-h2" data-i18n="layanan.website.options.title">
          Pilih Layanan Sesuai Kebutuhan Anda
        </h2>
        <p class="rb-lead max-w-2xl" data-i18n="layanan.website.options.subtitle">
          Kami menyediakan solusi fleksibel, mulai dari website instan untuk peluncuran cepat hingga ekosistem custom app
          web yang kompleks.
        </p>
      </div>

      <div class="grid gap-8 md:grid-cols-2">
        <!-- Mainstream Website -->
        <div
          class="rb-card p-8 flex flex-col h-full">
          <div class="mb-6 inline-block bg-tint p-3">
            <i data-lucide="layout" class="h-8 w-8 text-brand"></i>
          </div>
          <h3 class="text-xl font-semibold text-navy mb-3" data-i18n="layanan.website.options.mainstream.title">Website Mainstream</h3>
          <p class="text-sm leading-relaxed text-muted mb-6 flex-grow" data-i18n="layanan.website.options.mainstream.desc">
            Solusi tepat untuk kebutuhan <strong>company profile, landing page, atau blog</strong>. Dibuat dengan cepat
            menggunakan Web Builder dan CMS seperti WordPress untuk hasil yang elegan dan mudah dikelola.
          </p>
          <ul class="space-y-3 mb-8">
            <li class="flex items-start gap-3">
              <i data-lucide="check-circle-2" class="h-5 w-5 text-brand flex-shrink-0 mt-0.5"></i>
              <span class="text-sm text-ink" data-i18n="layanan.website.options.mainstream.bullet1">Waktu pengerjaan cepat (1-3 minggu)</span>
            </li>
            <li class="flex items-start gap-3">
              <i data-lucide="check-circle-2" class="h-5 w-5 text-brand flex-shrink-0 mt-0.5"></i>
              <span class="text-sm text-ink" data-i18n="layanan.website.options.mainstream.bullet2">Biaya lebih efisien (Cocok untuk UMKM)</span>
            </li>
            <li class="flex items-start gap-3">
              <i data-lucide="check-circle-2" class="h-5 w-5 text-brand flex-shrink-0 mt-0.5"></i>
              <span class="text-sm text-ink" data-i18n="layanan.website.options.mainstream.bullet3">Menggunakan Premium Template / Web Builder</span>
            </li>
          </ul>
          <!-- <div class="space-y-3 mt-auto">
              <a href="https://wa.me/" target="_blank" class="rb-btn rb-btn--navy w-full">Pilih Website
                Mainstream</a>
            </div> -->
          <div class="space-y-3 mt-3">
            <a href="https://wa.me/6285117494221" target="_blank" rel="noopener" class="rb-btn rb-btn--navy w-full" data-i18n="layanan.website.options.mainstream.cta">Konsultasi Website</a>
          </div>
        </div>

        <!-- Website App -->
        <div
          class="rb-card p-8 flex flex-col h-full">
          <div class="mb-6 inline-block bg-tint p-3">
            <i data-lucide="code-2" class="h-8 w-8 text-brand"></i>
          </div>
          <h3 class="text-xl font-semibold text-navy mb-3" data-i18n="layanan.website.options.custom.title">Custom Website App</h3>
          <p class="text-sm leading-relaxed text-muted mb-6 flex-grow" data-i18n="layanan.website.options.custom.desc">
            Sistem aplikasi berbasis web yang kompleks seperti <strong>Sistem Informasi (ERP/CRM), SaaS, atau Portal
              Custom</strong>. Dibangun dari nol menggunakan framework modern menyesuaikan bisnis Anda.
          </p>
          <ul class="space-y-3 mb-8">
            <li class="flex items-start gap-3">
              <i data-lucide="check-circle-2" class="h-5 w-5 text-brand flex-shrink-0 mt-0.5"></i>
              <span class="text-sm text-ink" data-i18n="layanan.website.options.custom.bullet1">Custom Business Logic & Skalabilitas Tinggi</span>
            </li>
            <li class="flex items-start gap-3">
              <i data-lucide="check-circle-2" class="h-5 w-5 text-brand flex-shrink-0 mt-0.5"></i>
              <span class="text-sm text-ink" data-i18n="layanan.website.options.custom.bullet2">Teknologi Modern (Laravel, React, Node.js)</span>
            </li>
            <li class="flex items-start gap-3">
              <i data-lucide="check-circle-2" class="h-5 w-5 text-brand flex-shrink-0 mt-0.5"></i>
              <span class="text-sm text-ink" data-i18n="layanan.website.options.custom.bullet3">Database Kompleks & Integrasi API Eksternal</span>
            </li>
          </ul>
          <a href="https://wa.me/6285117494221" target="_blank"
            class="rb-btn rb-btn--navy w-full mt-auto" data-i18n="layanan.website.options.custom.cta">Konsultasi Custom App</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Domain Check Section -->
  <section id="domain-check" class="rb-section bg-white px-6 text-ink">
    <div class="mx-auto w-full max-w-[80rem] space-y-12">
      <div class="space-y-4">
        <p class="rb-eyebrow" data-i18n="layanan.website.domain.tag">CEK NAMA DOMAIN</p>
        <h2 class="rb-h2" data-i18n="layanan.website.domain.title">Cari & Cek
          Ketersediaan Domain</h2>
        <p class="rb-lead max-w-2xl" data-i18n="layanan.website.domain.desc">Masukkan nama
          domain yang Anda inginkan lalu pilih ekstensi (TLD). Kami akan mengecek ketersediaannya secara real-time.</p>
      </div>

      <div class="rb-card p-8">
        <form id="domain-form" class="space-y-6">
          <div>
            <label for="domain-name" class="sr-only" data-i18n="layanan.website.domain.nameLabel">Nama Domain</label>
            <div class="relative">
              <i data-lucide="globe" class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
              <input id="domain-name" type="text" placeholder="contoh: namabisnis.com"
                class="w-full border border-line bg-paper pl-12 pr-4 py-3 text-sm placeholder-muted focus:outline focus:outline-2 focus:outline-sky"
                required data-i18n-placeholder="layanan.website.domain.placeholder">
            </div>
          </div>
          <div class="flex flex-wrap gap-4">
            <button id="check-domain-btn" type="submit" class="rb-btn rb-btn--navy">
              <i data-lucide="search" class="w-5 h-5 mr-2"></i>
              <span data-i18n="layanan.website.domain.checkBtn">Cek Ketersediaan</span>
            </button>
            <button id="clear-domain-btn" type="button" class="rb-btn rb-btn--line">
              <i data-lucide="x-circle" class="w-5 h-5 mr-2"></i>
              <span data-i18n="layanan.website.domain.clearBtn">Bersihkan</span>
            </button>
          </div>
        </form>

        <div id="domain-result" class="mt-8 hidden">
          <div id="domain-status-card" class="p-6 border"></div>
          <div id="domain-suggestions" class="mt-6"></div>
        </div>
      </div>

      <!-- Popular TLD Pricing -->
      <div class="space-y-4">
        <h3 class="text-base font-semibold text-navy" data-i18n="layanan.website.domain.pricingTitle">Harga Domain
          Populer (per tahun)</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div class="rb-card flex items-center justify-between px-5 py-4">
            <span class="text-sm font-semibold text-navy">.com</span>
            <span class="text-xs text-muted" data-lang-id="domain-price-com">Rp. 185.000/thn</span>
          </div>
          <div class="rb-card flex items-center justify-between px-5 py-4">
            <span class="text-sm font-semibold text-navy">.co.id</span>
            <span class="text-xs text-muted" data-lang-id="domain-price-coid">Rp. 300.000/thn</span>
          </div>
          <div class="rb-card flex items-center justify-between px-5 py-4">
            <span class="text-sm font-semibold text-navy">.id</span>
            <span class="text-xs text-muted" data-lang-id="domain-price-id">Rp. 129.000/thn</span>
          </div>
          <div class="rb-card flex items-center justify-between px-5 py-4">
            <span class="text-sm font-semibold text-navy">.co</span>
            <span class="text-xs text-muted" data-lang-id="domain-price-co">Rp. 450.000/thn</span>
          </div>
        </div>
      </div>

      <p class="text-xs text-muted" data-i18n="layanan.website.domain.dataSource">Sumber data: RDAP &
        DNS Google • Hasil hanya indikatif, ketersediaan final mengikuti registrar.</p>
    </div>
  </section>

  <x-web.layanan-process prefix="website" />

  @include('components.web.faq-section', [
    
    'subtitleKey' => 'faq.subtitle.website',
    'items' => [
      ['questionKey' => 'faq.website.q1', 'answerKey' => 'faq.website.a1'],
      ['questionKey' => 'faq.website.q2', 'answerKey' => 'faq.website.a2'],
      ['questionKey' => 'faq.website.q3', 'answerKey' => 'faq.website.a3'],
      ['questionKey' => 'faq.website.q4', 'answerKey' => 'faq.website.a4'],
    ],
  ])

  <x-web.cta-consultation />
@endsection

@section('script')
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    // Initialize Lucide Icons
    document.addEventListener('DOMContentLoaded', function () {
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

      domainStatusCard.className = `p-6 border ${bg} ${border}`;
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
                              <a href="{{ route('web.contact.index') }}" class="rb-btn rb-btn--navy flex-shrink-0">
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
        domainStatusCard.className = 'p-6 border bg-yellow-50 border-yellow-200';
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
          domainStatusCard.className = 'p-6 border bg-red-50 border-red-200';
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