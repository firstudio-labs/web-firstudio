@extends('template_web.layout')

@section('content')
 <!-- Hero Section -->
 <section class="hero-section hero-section--slim text-white">
      <div class="mx-auto w-full max-w-6xl">
        <h1 class="hero-heading">
          Articles
          <span class="flip-words-container text-blue-500">
            <span class="flip-word" data-word="Artikel">Artikel</span>
          </span>
        </h1>
        <p class="hero-subtitle">
          Temukan artikel menarik tentang teknologi, tips bisnis digital, dan insight terbaru dari tim Firstudio.
        </p>
      </div>
    </section>

    <!-- Articles Section -->
    <section class="bg-black py-20">
        <!-- Filter Buttons -->
        <!-- @if($kategoriArtikels->count() > 0)
        <div class="filter-controls mb-12">
          <a href="{{ route('web.artikel.index') }}" class="filter-btn btn {{ $kategori === 'all' ? 'btn-primary active' : 'btn-outline' }}" data-filter="all">
            Semua Artikel
          </a>
          @foreach($kategoriArtikels as $kat)
            <a href="{{ route('web.artikel.index', ['kategori' => $kat->slug]) }}" class="filter-btn btn {{ $kategori === $kat->slug ? 'btn-primary active' : 'btn-outline' }}" data-filter="{{ $kat->slug }}">
              {{ $kat->kategori_artikel }}
            </a>
          @endforeach
        </div>
        @endif -->

        <!-- Focus Cards Section -->
        <div class="focus-cards-container">
          @forelse($artikels as $artikel)
            <a 
              href="{{ route('web.artikel.show', $artikel->slug) }}" 
              class="focus-card"
              @if($artikel->gambar)
                style="background-image: url('{{ asset('storage/artikel/' . $artikel->gambar) }}');"
              @else
                style="background-image: url('https://images.unsplash.com/photo-1518710843675-2540dd79065c?q=80&w=3387&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');"
              @endif
            >
              <div class="focus-card__content">
                <span class="focus-card__date">
                  {{ $artikel->created_at ? $artikel->created_at->format('d F Y') : 'Tanggal tidak tersedia' }}
                </span>
                <h3 class="focus-card__title">{{ $artikel->judul }}</h3>
              </div>
            </a>
          @empty
            <!-- Empty State -->
            <div class="col-span-full text-center py-20">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-24 w-24 text-gray-300">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
              </svg>
              <h3 class="mt-4 text-xl font-semibold text-white">Tidak ada artikel ditemukan</h3>
              <p class="mt-2 text-gray-400">Coba pilih kategori lain untuk melihat artikel kami</p>
            </div>
          @endforelse
        </div>

        <!-- Pagination -->
        @if($artikels->hasPages())
          <div class="flex justify-center mt-12">
            {{ $artikels->links() }}
          </div>
        @endif
    </section>
@endsection
