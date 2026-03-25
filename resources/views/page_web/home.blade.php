@extends('template_web.layout')

@section('content')
<!-- Hero Section -->
<main
      id="hero"
      class="hero-section relative isolate flex min-h-[100vh] w-full flex-col items-center justify-center overflow-hidden bg-black px-6 py-24 text-white"
    >
      <div
        class="pointer-events-none absolute inset-0 z-0 flex w-full items-start justify-center"
      >
        <div
          class="absolute top-0 h-48 w-full bg-gradient-to-b from-blue-500/20 via-transparent to-transparent opacity-60 blur-2xl"
        ></div>
        <div
          class="absolute top-4 h-40 w-[32rem] rounded-full bg-blue-500/30 opacity-80 blur-[120px]"
        ></div>
        <div
          class="absolute top-10 h-36 w-[28rem] rounded-full bg-blue-400/20 opacity-70 blur-3xl"
        ></div>
        <div
          class="absolute inset-auto right-1/2 top-8 h-56 w-[32rem] opacity-70 blur-3xl"
          style="
            background-image: conic-gradient(
              from 60deg at 50% 0%,
              rgba(59, 130, 246, 0.4),
              transparent 70%
            );
          "
        ></div>
        <div
          class="absolute inset-auto left-1/2 top-8 h-56 w-[32rem] opacity-70 blur-3xl"
          style="
            background-image: conic-gradient(
              from 300deg at 50% 0%,
              transparent 30%,
              rgba(59, 130, 246, 0.4)
            );
          "
        ></div>
      </div>

      <div
        class="relative z-10 mx-auto flex max-w-3xl flex-col items-center gap-6 text-center"
      >
        <p
          class="font-secondary text-xs uppercase tracking-[0.6em] text-white/60"
        >
          {{ $beranda->slogan ?? 'Firstudio' }}
        </p>
        <h1
          class="font-primary text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl lg:text-7xl"
        >
          {{ $beranda->judul_utama ?? 'Solusi Digital untuk Bisnis Anda' }}
        </h1>
        <p
          class="font-secondary text-lg leading-relaxed text-white/70 md:text-xl"
        >
          {{ $beranda->keterangan ?? 'Kami membantu Anda mengembangkan bisnis digital dengan solusi yang inovatif dan efisien.' }}
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
          <a
            href="#about"
            class="inline-block rounded-full border border-blue-500/40 bg-blue-500/10 px-5 py-2 text-sm font-semibold text-white transition hover:bg-blue-500/20"
            aria-label="Selengkapnya tentang Firstudio"
          >
            Selengkapnya
          </a>
        </div>
      </div>
    </main>

    <!-- About Section -->
    @if($tentang)
    <section id="about" class="about-section bg-black px-6 py-20 text-white">
      <div
        class="mx-auto flex w-full max-w-6xl flex-col gap-12 rounded-3xl border border-white/10 bg-gradient-to-br from-black via-black to-zinc-900/90 p-10 text-white lg:flex-row lg:items-center lg:justify-between"
      >
        <div class="max-w-md space-y-4">
          <p
            class="text-sm font-semibold uppercase tracking-[0.5em] text-white/60"
          >
            {{ $tentang->keterangan_memilih ?? 'Mengapa Firstudio?' }}
          </p>
          <h2 class="font-primary text-4xl font-bold leading-tight text-white">
            {{ $tentang->judul ?? 'Struktur Branding yang Disiplin' }}
          </h2>
          <div class="h-1 w-24 rounded-full bg-blue-500"></div>
          <p class="text-base text-white/70">
            {!! $tentang->deskripsi !!}
          </p>
          <a
            href="{{ route('web.about.index') }}"
            class="inline-block rounded-full border border-blue-500/40 bg-blue-500 text-white px-5 py-2 text-sm font-semibold shadow-[0_10px_25px_rgba(59,130,246,0.4)] transition hover:bg-blue-600"
          >
            Tentang Kami
          </a>
        </div>
        <div class="grid grid-cols-3 grid-rows-3 gap-3">
          <div class="h-24 w-24 rounded-t-full bg-white"></div>
          <div class="h-24 w-24 rounded-br-[2.5rem] bg-blue-500"></div>
          <div class="h-24 w-24 rounded-full bg-zinc-800"></div>
          <div
            class="h-24 w-24 rounded-bl-[2.5rem] bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600"
          ></div>
          <div class="h-24 w-24 rounded-full bg-white/90"></div>
          <div
            class="h-24 w-24 rounded-tr-[2.5rem] bg-gradient-to-br from-zinc-800 via-blue-600 to-blue-500"
          ></div>
          <div class="h-24 w-24 rounded-full bg-zinc-900"></div>
          <div
            class="h-24 w-24 rounded-t-[2.5rem] bg-gradient-to-b from-white via-blue-400 to-blue-600"
          ></div>
          <div
            class="h-24 w-24 rounded-full bg-gradient-to-tr from-black via-blue-600 to-white"
          ></div>
        </div>
      </div>
    </section>
    @endif

    <!-- Services Section -->
    <section
      id="services"
      class="services-section bg-white px-6 py-20 text-gray-900"
    >
      <div class="mx-auto w-full max-w-6xl space-y-12">
        <h2 class="font-primary text-3xl font-semibold text-gray-900">
          Our Services
        </h2>

        <div
          class="flex flex-col gap-10 rounded-[32px] border border-gray-200 bg-white p-8 md:flex-row"
        >
          <div
            class="flex w-full items-center justify-center rounded-2xl border border-gray-100 bg-gray-50 p-4 md:w-1/2"
          >
            <div class="service-media">
              <img src="{{ asset('web/assets/layanan/website.png') }}" alt="Website App Development - Jasa Pembuatan Website Profesional" class="service-media__img" width="600" height="400" loading="lazy">
            </div>
          </div>
          <div class="flex w-full flex-col gap-6 md:w-1/2">
            <div>
              <a href="{{ route('web.layanan.website') }}"><h3 class="text-3xl font-semibold text-gray-900">Website App Development</h3></a>
              <p class="mt-3 text-gray-600">
                Kami merancang dan membangun website yang responsif, aman, dan mudah dikelola, mulai dari company profile hingga sistem informasi khusus.
              </p>
            </div>
            <div class="space-y-4">
              <p class="text-base font-semibold text-gray-900">
                Layanan kami meliputi:
              </p>
              <div class="grid gap-3 text-sm text-gray-700 sm:grid-cols-2">
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Analisis kebutuhan dan perencanaan struktur konten.
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Desain UI/UX yang menarik dan intuitif.
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Pengembangan frontend dan backend.
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Integrasi layanan tambahan.
                </span>
              </div>
            </div>
            <div
              class="flex flex-wrap items-center gap-4 text-sm font-semibold"
            >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Laravel</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >React</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Node.js</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Tailwind CSS</span
              >
            </div>
          </div>
        </div>

        <div
          class="flex flex-col gap-10 rounded-[32px] border border-gray-200 bg-white p-8  md:flex-row"
        >
          <div class="flex w-full flex-col gap-6 md:w-1/2">
            <div>
              <a href="{{ route('web.layanan.mobile') }}"><h3 class="text-3xl font-semibold text-gray-900">Mobile App Development</h3></a>
              <p class="mt-3 text-gray-600">
                Kami mengembangkan aplikasi mobile berbasis Android dengan tampilan yang nyaman dan fitur yang kuat,
                 baik menggunakan native maupun cross-platform seperti Flutter.
              </p>
            </div>
            <div class="space-y-4">
              <p class="text-base font-semibold text-gray-900">
                Layanan kami meliputi:
              </p>
              <div class="grid gap-3 text-sm text-gray-700 sm:grid-cols-2">
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Analisis kebutuhan dan perencanaan fitur.
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Pengembangan aplikasi native.
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Pengembangan aplikasi cross-platform.
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Integrasi API dan layanan eksternal.
                </span>
              </div>
            </div>
            <div
              class="flex flex-wrap items-center gap-4 text-sm font-semibold"
            >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Flutter</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >React Native</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Dart</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Kotlin</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Java</span
              >
            </div>
          </div>
          <div
            class="flex w-full items-center justify-center rounded-2xl border border-gray-100 bg-gray-50 p-4 md:w-1/2"
          >
            <div class="service-media">
              <img src="{{ asset('web/assets/layanan/mobile.png') }}" alt="Mobile App Development - Jasa Pembuatan Aplikasi Mobile" class="service-media__img" width="600" height="400" loading="lazy">
            </div>
          </div>
        </div>

        <div
          class="flex flex-col gap-10 rounded-[32px] border border-gray-200 bg-white p-8  md:flex-row"
        >
          <div
            class="flex w-full items-center justify-center rounded-2xl border border-gray-100 bg-gray-50 p-4 md:w-1/2"
          >
            <div class="service-media">
              <img src="{{ asset('web/assets/layanan/company.png') }}" alt="Company Profile - Jasa Pembuatan Company Profile Profesional" class="service-media__img" width="600" height="400" loading="lazy">
            </div>
          </div>
          <div class="flex w-full flex-col gap-6 md:w-1/2">
            <div>
              <a href="{{ route('web.layanan.company') }}"><h3 class="text-3xl font-semibold text-gray-900">Company Profile</h3></a>
              <p class="mt-3 text-gray-600">
                Kami membantu perusahaan menampilkan identitas dan kredibilitas bisnis secara profesional melalui Company Profile.
              </p>
            </div>
            <div class="space-y-4">
              <p class="text-base font-semibold text-gray-900">
                Layanan kami meliputi:
              </p>
              <div class="grid gap-3 text-sm text-gray-700 sm:grid-cols-2">
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Riset & perencanaan konten
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Copywriting profesional
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Desain visual & branding
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Format cetak dan digital
                </span>
              </div>
            </div>
            <div
              class="flex flex-wrap items-center gap-4 text-sm font-semibold"
            >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Canva</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Adobe Photoshop</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Adobe Illustrator</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Adobe InDesign</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Adobe Acrobat</span
              >
            </div>
          </div>
        </div>

        <div
          class="flex flex-col gap-10 rounded-[32px] border border-gray-200 bg-white p-8  md:flex-row"
        >
          <div class="flex w-full flex-col gap-6 md:w-1/2">
            <div>
              <a href="{{ route('web.layanan.itconsul') }}"><h3 class="text-3xl font-semibold text-gray-900">IT Consultation</h3></a>
              <p class="mt-3 text-gray-600">
                Kami hadir sebagai partner teknologi Anda, memberikan rekomendasi dan solusi digital terkini yang dirancang untuk 
                meningkatkan efisiensi operasional dan produktivitas perusahaan. Mulai dari pemilihan teknologi yang tepat, optimalisasi 
                sistem yang sudah berjalan, hingga strategi pengembangan jangka panjang.</p>
            </div>
            <div class="space-y-4">
              <p class="text-base font-semibold text-gray-900">
                Layanan kami meliputi:
              </p>
              <div class="grid gap-3 text-sm text-gray-700 sm:grid-cols-2">
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Konsultasi teknologi terkini.
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Konsultasi penggunaan teknologi.
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Konsultasi pengembangan sistem informasi.
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Konsultasi pengembangan aplikasi mobile.
                </span>
              </div>
            </div>
            <div
              class="flex flex-wrap items-center gap-4 text-sm font-semibold"
            >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >VPS Hosting</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Domain Hosting</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Email Server</span
              >
            </div>
          </div>
          <div
            class="flex w-full items-center justify-center rounded-2xl border border-gray-100 bg-gray-50 p-4 md:w-1/2"
          >
            <div class="service-media">
              <img src="{{ asset('web/assets/layanan/itconsul.png') }}" alt="IT Consultation - Konsultasi Teknologi untuk Bisnis" class="service-media__img" width="600" height="400" loading="lazy">
            </div>
          </div>
          </div>

                 <div
          class="flex flex-col gap-10 rounded-[32px] border border-gray-200 bg-white p-8  md:flex-row"
        >
          <div
            class="flex w-full items-center justify-center rounded-2xl border border-gray-100 bg-gray-50 p-4 md:w-1/2"
          >
            <div class="service-media">
              <img src="{{ asset('web/assets/layanan/outsourcing.jpg') }}" alt="Company Profile - Jasa Pembuatan Company Profile Profesional" class="service-media__img" width="600" height="400" loading="lazy">
            </div>
          </div>
          <div class="flex w-full flex-col gap-6 md:w-1/2">
            <div>
              <a href="{{ route('web.layanan.itoutsourcing') }}"><h3 class="text-3xl font-semibold text-gray-900">IT Outsourcing</h3></a>
              <p class="mt-3 text-gray-600">
                Layanan penyediaan tenaga IT profesional seperti Software Developer, UI/UX Designer, System Analyst, dan Project Manager secara terdedikasi. Kami siap mendukung pengembangan proyek teknologi perusahaan Anda dengan sistem kontrak yang transparan dan kompetitif.
              </p>
            </div>
            <div class="space-y-4">
              <p class="text-base font-semibold text-gray-900">
                Layanan kami meliputi:
              </p>
              <div class="grid gap-3 text-sm text-gray-700 sm:grid-cols-2">
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Dedicated Developers.
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Staff Augmentation.
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  Project-based Teams.
                </span>
                <span class="flex items-center gap-3">
                  <span class="h-px w-6 bg-blue-500"></span>
                  UI/UX Designers & QA.
                </span>
              </div>
            </div>
            <div
              class="flex flex-wrap items-center gap-4 text-sm font-semibold"
            >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Senior Level</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Mid Level</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >On-site</span
              >
              <span class="rounded-full border border-blue-500/30 bg-blue-500/5 px-4 py-1 text-blue-600"
                >Remote</span
              >
            </div>
          </div>
        </div>

        </div>
      </div>
    </section>

    <!-- Projects Section -->
    @if($produk && $produk->count() > 0)
    <section
      id="projects"
      class="projects-section bg-black px-6 py-20 text-white"
    >
      <div class="mx-auto w-full max-w-6xl space-y-10">
        <h2 class="font-primary text-3xl font-semibold text-white">
          Our Latest Projects
        </h2>

        <div class="grid gap-6 md:grid-cols-3">
          @foreach($produk as $index => $item)
            @if($index < 5)
            <article
              class="rounded-[28px] border border-white/15 bg-black/40 p-4 {{ $index == 3 ? 'md:col-span-2' : '' }}"
            >
              <div
                class="{{ $index == 3 ? 'h-52' : 'h-44' }} w-full rounded-2xl border border-blue-500/20 bg-gradient-to-br from-blue-500/20 via-blue-500/10 to-transparent overflow-hidden"
              >
                @if($item->gambar)
                  <img 
                    src="{{ asset('storage/produk/' . $item->gambar) }}" 
                    alt="{{ $item->judul }}" 
                    class="w-full h-full object-cover rounded-2xl" 
                    width="{{ $index == 3 ? '800' : '400' }}" 
                    height="{{ $index == 3 ? '400' : '300' }}" 
                    loading="lazy"
                  >
                @else
                  <div class="w-full h-full flex items-center justify-center text-white/50">
                    No Image
                  </div>
                @endif
              </div>
              <div class="mt-4 space-y-2">
                <span class="text-sm text-white/50">
                  @if($item->kategoriProduk)
                    {{ $item->kategoriProduk->nama ?? 'Project' }}
                  @else
                    Project
                  @endif
                </span>
                @php
                  $detailUrl = $item->link ?: route('web.produk.show', $item->slug ?? $item->id);
                  $isExternal = (bool) $item->link;
                @endphp
                <a 
                  href="{{ $detailUrl }}" 
                  class="hover:text-blue-500"
                  @if($isExternal) target="_blank" rel="noopener" @endif
                >
                  <h3 class="text-lg font-semibold">{{ $item->judul }}</h3>
                </a>
                <p class="text-sm text-white/70 line-clamp-3">
                  {{ \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 150) }}
                </p>
              </div>
            </article>
            @endif
          @endforeach
        </div>
      </div>
    </section>
    @endif

    <!-- Articles Section -->
    <section
      id="articles"
      class="articles-section bg-gray-50 px-6 py-20"
    >
      <div class="mx-auto w-full max-w-6xl space-y-10">
        <div
          class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between"
        >
          <h2 class="font-primary text-3xl font-semibold text-gray-900">
            Articles
          </h2>
          <div class="flex items-center gap-3">
            <button
              class="rounded-full border border-blue-500/30 p-3 text-lg text-gray-900 transition hover:bg-blue-500 hover:text-white hover:border-blue-500"
              aria-label="Artikel sebelumnya"
              data-article-prev
            >
              ←
            </button>
            <button
              class="rounded-full border border-blue-500/30 p-3 text-lg text-gray-900 transition hover:bg-blue-500 hover:text-white hover:border-blue-500"
              aria-label="Artikel berikutnya"
              data-article-next
            >
              →
            </button>
          </div>
        </div>

        <div class="relative">
          <div
            id="article-carousel"
            class="flex gap-6 overflow-x-auto scroll-smooth pb-6 [scrollbar-width:none]"
          >
            @forelse($artikel as $item)
              <a 
                href="{{ route('web.artikel.show', $item->slug ?? $item->id) ?? '#' }}" 
                class="focus-card flex-shrink-0 w-[300px] md:w-[380px]"
                @if($item->gambar)
                  style="background-image: url('{{ asset('storage/artikel/' . $item->gambar) }}');"
                @else
                  style="background-image: url('https://images.unsplash.com/photo-1518710843675-2540dd79065c?q=80&w=3387&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');"
                @endif
              >
                <div class="focus-card__content">
                  <span class="focus-card__date">{{ $item->created_at ? $item->created_at->format('d F Y') : 'Tanggal tidak tersedia' }}</span>
                  <h3 class="focus-card__title">{{ $item->judul }}</h3>
                </div>
              </a>
            @empty
              <p class="text-gray-600">Belum ada artikel tersedia.</p>
            @endforelse
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    @if($testimoni && $testimoni->count() > 0)
    <section
      id="testimonials"
      class="testimonials-section bg-black px-6 py-20 text-white"
    >
      <div class="mx-auto w-full max-w-6xl space-y-10">
        <div class="testimonial-slider">
          <div class="testimonial-track">
            @foreach($testimoni as $item)
              <article
                class="testimonial-card w-[450px] rounded-2xl bg-zinc-900 p-8 text-white"
              >
                <blockquote class="space-y-6">
                  <p class="text-lg leading-relaxed text-white/90">
                    "{{ $item->testimoni }}"
                  </p>
                  <footer class="space-y-1">
                    <p class="font-semibold text-white">{{ $item->nama }}</p>
                    <p class="text-sm text-white/60">{{ $item->jabatan }}</p>
                  </footer>
                </blockquote>
              </article>
            @endforeach
            {{-- Duplicate untuk efek infinite scroll --}}
            @foreach($testimoni as $item)
              <article
                class="testimonial-card w-[450px] rounded-2xl bg-zinc-900 p-8 text-white"
              >
                <blockquote class="space-y-6">
                  <p class="text-lg leading-relaxed text-white/90">
                    "{{ $item->testimoni }}"
                  </p>
                  <footer class="space-y-1">
                    <p class="font-semibold text-white">{{ $item->nama }}</p>
                    <p class="text-sm text-white/60">{{ $item->jabatan }}</p>
                  </footer>
                </blockquote>
              </article>
            @endforeach
          </div>
        </div>
      </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section id="cta" class="cta-section bg-gray-50 px-6 py-20">
      <div
        class="cta-card mx-auto flex w-full max-w-6xl flex-col gap-12 rounded-3xl bg-white p-12 shadow-lg md:flex-row md:items-center md:justify-between"
      >
        <div class="flex-1 space-y-6">
          <h2
            class="font-primary text-4xl font-bold leading-tight text-gray-900 md:text-5xl"
          >
          Apa yang ingin kamu tanyakan?
          </h2>
          <p class="text-lg leading-relaxed text-gray-600">
            Konsultasikan kebutuhan digital Anda bersama tim profesional kami. Kami siap membantu Anda berkembang!
          </p>
          <a
            href="{{ route('web.contact.index') }}"
            class="inline-block rounded-full border border-blue-500/40 bg-blue-500 text-white px-5 py-2 text-sm font-semibold shadow-[0_10px_25px_rgba(59,130,246,0.4)] transition hover:bg-blue-600"
            aria-label="Konsultasi Gratis - Hubungi Firstudio"
          >
            Konsultasi Gratis
          </a>
        </div>
        <div class="flex-1 space-y-4">
          <div class="flex items-center gap-3">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="h-6 w-6 flex-shrink-0 text-blue-500"
            >
              <path
                fill-rule="evenodd"
                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                clip-rule="evenodd"
              />
            </svg>
            <span class="text-lg font-semibold text-gray-900"
              >Konsultasi Gratis</span
            >
          </div>
          <div class="flex items-center gap-3">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="h-6 w-6 flex-shrink-0 text-blue-500"
            >
              <path
                fill-rule="evenodd"
                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                clip-rule="evenodd"
              />
            </svg>
            <span class="text-lg font-semibold text-gray-900"
              >Mudah Digunakan</span
            >
          </div>
          <div class="flex items-center gap-3">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="h-6 w-6 flex-shrink-0 text-blue-500"
            >
              <path
                fill-rule="evenodd"
                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                clip-rule="evenodd"
              />
            </svg>
            <span class="text-lg font-semibold text-gray-900"
              >Jaminan Kualitas</span
            >
          </div>
          <div class="flex items-center gap-3">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="h-6 w-6 flex-shrink-0 text-blue-500"
            >
              <path
                fill-rule="evenodd"
                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                clip-rule="evenodd"
              />
            </svg>
            <span class="text-lg font-semibold text-gray-900"
              >Garansi Penuh</span
            >
          </div>
          <div class="flex items-center gap-3">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="h-6 w-6 flex-shrink-0 text-blue-500"
            >
              <path
                fill-rule="evenodd"
                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                clip-rule="evenodd"
              />
            </svg>
            <span class="text-lg font-semibold text-gray-900"
              >Dukungan 24/7</span
            >
          </div>
        </div>
      </div>
    </section>
@endsection