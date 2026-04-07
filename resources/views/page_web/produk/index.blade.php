@extends('template_web.layout')

@section('content')
 <!-- Hero Section -->
 <section class="hero-section hero-section--slim text-white">
      <div class="mx-auto w-full max-w-6xl">
        <h1 class="hero-heading">
          Portfolio
          <span class="flip-words-container text-blue-500">
            <span class="flip-word" data-word="Kami">Kami</span>
          </span>
        </h1>
        <p class="hero-subtitle">
          Lihat koleksi proyek yang telah kami selesaikan dengan berbagai klien dari berbagai industri. Setiap proyek dirancang dengan perhatian detail dan komitmen untuk memberikan hasil terbaik.
        </p>
      </div>
    </section>

    <!-- Portfolio Section -->
    <section class="bg-gray-50 px-6 py-20 text-gray-900">
      <div class="mx-auto w-full max-w-6xl space-y-12">
        <!-- Filter Buttons -->
        <div class="filter-controls">
          <a href="{{ route('web.produk.index') }}" class="filter-btn btn {{ $kategori === 'all' ? 'btn-primary active' : 'btn-outline' }}" data-filter="all">
            Semua Project
          </a>
          @foreach($kategori_produks as $kat)
            <a href="{{ route('web.produk.index', ['kategori' => $kat->slug]) }}" class="filter-btn btn {{ $kategori === $kat->slug ? 'btn-primary active' : 'btn-outline' }}" data-filter="{{ $kat->slug }}">
              {{ $kat->kategori_produk }}
            </a>
          @endforeach
        </div>

        <!-- Portfolio Grid -->
        <div class="grid gap-6 md:grid-cols-3" id="portfolio-grid">
          @forelse($produks as $produk)
            @php
              $kategoriSlug = $produk->kategoriProduk ? $produk->kategoriProduk->slug : 'all';
              // Mapping kategori untuk filter
              $categoryMap = [
                'website-development' => 'website',
                'mobile-app' => 'mobile',
                'company-profile' => 'company-profile',
                'it-solution' => 'it-solution',
              ];
              $filterCategory = $categoryMap[$kategoriSlug] ?? 'website';
            @endphp
            @php
              $detailUrl = $produk->link ?: route('web.produk.show', $produk->slug);
              $isExternal = (bool) $produk->link;
            @endphp
            <article class="rounded-[28px] border border-white/15 bg-black/40 p-4 dark:bg-gray-50 dark:border-gray-200" data-category="{{ $filterCategory }}">
              <div class="h-44 w-full rounded-2xl border border-blue-500/20 bg-gradient-to-br from-blue-500/20 via-blue-500/10 to-transparent overflow-hidden">
                @if($produk->gambar)
                  <img 
                    src="{{ asset('storage/produk/' . $produk->gambar) }}" 
                    alt="{{ $produk->judul }}" 
                    class="w-full h-full object-cover rounded-2xl" 
                    width="400" 
                    height="300" 
                    loading="lazy"
                  >
                @else
                  <div class="flex h-full w-full items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-16 w-16 text-blue-400">
                      <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
                      <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
              </svg>
            </div>
                @endif
            </div>
            <div class="mt-4 space-y-2">
                <span class="text-sm text-white/50 dark:text-gray-900">
                  {{ $produk->kategoriProduk ? $produk->kategoriProduk->kategori_produk : 'Project' }}
                </span>
                <a href="{{ $detailUrl }}" class="hover:text-blue-500" @if($isExternal) target="_blank" rel="noopener" @endif>
                  <h3 class="text-lg font-semibold text-white dark:text-gray-900">{{ $produk->judul }}</h3>
                </a>
              <p class="text-sm text-white/70 dark:text-gray-900">
                  {{ \Illuminate\Support\Str::limit(strip_tags($produk->deskripsi), 120) }}
              </p>
              <div class="pt-2">
                
              </div>
            </div>
          </article>
          @empty
        <!-- Empty State -->
            <div class="col-span-full text-center py-20">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-24 w-24 text-gray-300">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>
          <h3 class="mt-4 text-xl font-semibold text-gray-900">Tidak ada project ditemukan</h3>
          <p class="mt-2 text-gray-600">Coba pilih kategori lain untuk melihat project kami</p>
            </div>
          @endforelse
        </div>
      </div>
    </section>

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
          >
            Konsultasi Gratis
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="ml-2 inline-block h-4 w-4"
            >
              <path
                fill-rule="evenodd"
                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                clip-rule="evenodd"
              />
            </svg>
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

@section('script')
<script>
  // Filter functionality (optional - for client-side filtering if needed)
  document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('#portfolio-grid article');
    
    filterButtons.forEach(button => {
      button.addEventListener('click', function(e) {
        // If it's a link, let it navigate naturally
        if (this.tagName === 'A') {
          return;
        }
        
        e.preventDefault();
        const filter = this.getAttribute('data-filter');
        
        // Update active state
        filterButtons.forEach(btn => {
          btn.classList.remove('active', 'btn-primary');
          btn.classList.add('btn-outline');
        });
        this.classList.add('active', 'btn-primary');
        this.classList.remove('btn-outline');
        
        // Filter items
        portfolioItems.forEach(item => {
          if (filter === 'all' || item.getAttribute('data-category') === filter) {
            item.style.display = 'block';
          } else {
            item.style.display = 'none';
          }
        });
        
        // Show/hide empty state
        const visibleItems = Array.from(portfolioItems).filter(item => 
          item.style.display !== 'none'
        );
        const emptyState = document.getElementById('empty-state');
        if (emptyState) {
          if (visibleItems.length === 0) {
            emptyState.classList.remove('hidden');
          } else {
            emptyState.classList.add('hidden');
          }
        }
      });
    });
  });
</script>
@endsection
