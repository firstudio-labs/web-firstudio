@extends('template_web.layout')

@section('content')
  <!-- Hero Section About -->
  <section class="hero-section bg-black px-6 py-32 text-white">
      <div class="mx-auto flex w-full max-w-6xl items-center gap-12">
        <!-- Left Content -->
        <div class="flex-1 space-y-6">
          <h1 class="font-primary text-5xl font-bold leading-tight md:text-6xl">
              We are<br />Firstudio
          </h1>
          <p class="font-secondary text-lg leading-relaxed text-white/90">
            {!! strip_tags($tentang->deskripsi) !!}
          </p>
        </div>

        <!-- Right Image -->
        <div class="hidden flex-1 md:block">
          <div
            class="aspect-square w-full rounded-3xl border border-white/10 bg-white/5 overflow-hidden"
          >
              <div
                class="flex h-full w-full items-center justify-center rounded-3xl bg-gradient-to-br from-white/10 to-transparent"
              >
                <img 
                  src="{{ asset('web/assets/about/about.png') }}" 
                  alt="About Us" 
                  class="w-full h-full object-cover rounded-3xl"
                  onerror="this.style.display='none'; this.parentElement.innerHTML='<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'currentColor\' class=\'h-24 w-24 text-white/20\'><path d=\'M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z\'/><path d=\'M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z\'/></svg>';"
                >
              </div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Us Content -->
    <section class="bg-white px-6 py-20 text-gray-900">
      <div class="mx-auto w-full max-w-6xl space-y-16"> 
        <!-- Stats -->
        @if($tentang && $tentang->hitungan && count($tentang->hitungan) > 0)
          <div class="grid gap-8 md:grid-cols-{{ min(count($tentang->hitungan), 4) }}">
            @foreach($tentang->hitungan as $index => $hitungan)
              @if($hitungan && isset($tentang->keterangan_hitungan[$index]))
                <div class="space-y-2">
                  <h3 class="font-primary text-5xl font-bold text-blue-500">{{ $hitungan }}</h3>
                  <p class="font-secondary text-lg text-gray-600">
                    {{ $tentang->keterangan_hitungan[$index] }}
                  </p>
                </div>
              @endif
            @endforeach
          </div>
        @else
          <div class="grid gap-8 md:grid-cols-3">
            <div class="space-y-2">
              <h3 class="font-primary text-5xl font-bold text-blue-500">12+</h3>
              <p class="font-secondary text-lg text-gray-600">
                Years of Experience
              </p>
            </div>
            <div class="space-y-2">
              <h3 class="font-primary text-5xl font-bold text-blue-500">150+</h3>
              <p class="font-secondary text-lg text-gray-600">
                Projects Completed
              </p>
            </div>
            <div class="space-y-2">
              <h3 class="font-primary text-5xl font-bold text-blue-500">98%</h3>
              <p class="font-secondary text-lg text-gray-600">
                Client Satisfaction
              </p>
            </div>
          </div>
        @endif
      </div>
    </section>

    <!-- Our Values Section -->
    @if($tentang && $tentang->keterangan_nilai)
    <section class="bg-gray-50 px-6 py-20 text-gray-900">
      <div class="mx-auto w-full max-w-6xl">
        <h2 class="font-primary text-4xl font-bold mb-12">Our Values</h2>
        <div class="prose prose-lg max-w-none">
          <div class="font-secondary leading-relaxed text-gray-700 whitespace-pre-line">
            {!! $tentang->keterangan_nilai !!}
          </div>
        </div>
      </div>
    </section>
    @else
    <!-- We Are Section -->
    <section class="bg-gray-50 px-6 py-20 text-gray-900">
      <div class="mx-auto w-full max-w-6xl">
        <h2 class="font-primary text-4xl font-bold mb-12">Our Values</h2>
        <div class="grid gap-8 md:grid-cols-3">
          <!-- Future -->
          <div class="space-y-4 rounded-2xl bg-blue-500 p-8 text-white">
            <h3 class="font-primary text-2xl font-bold">Future</h3>
            <p class="font-secondary leading-relaxed text-white/90">
              Kami selalu melihat ke depan dan mengadopsi teknologi terbaru untuk memberikan solusi yang relevan dan berkelanjutan bagi klien kami.
            </p>
          </div>

          <!-- Innovative -->
          <div class="space-y-4 rounded-2xl bg-white p-8 shadow-lg">
            <h3 class="font-primary text-2xl font-bold text-gray-900">
              Innovative
            </h3>
            <p class="font-secondary leading-relaxed text-gray-700">
              Kami berkomitmen untuk memberikan solusi inovatif yang dapat membantu bisnis Anda berkembang dan bersaing di era digital.
            </p>
          </div>

          <!-- Research -->
          <div class="space-y-4 rounded-2xl bg-white p-8 shadow-lg">
            <h3 class="font-primary text-2xl font-bold text-gray-900">
              Research
            </h3>
            <p class="font-secondary leading-relaxed text-gray-700">
              Setiap proyek dimulai dengan riset mendalam untuk memahami kebutuhan dan tantangan bisnis Anda secara menyeluruh.
            </p>
          </div>

          <!-- Solution -->
          <div class="space-y-4 rounded-2xl bg-white p-8 shadow-lg">
            <h3 class="font-primary text-2xl font-bold text-gray-900">
              Solution
            </h3>
            <p class="font-secondary leading-relaxed text-gray-700">
              Kami fokus pada solusi yang tepat guna dan dapat diimplementasikan dengan efektif untuk mencapai tujuan bisnis Anda.
            </p>
          </div>

          <!-- Technology -->
          <div
            class="space-y-4 rounded-2xl bg-white p-8 shadow-lg md:col-span-2"
          >
            <h3 class="font-primary text-2xl font-bold text-gray-900">
              Technology
            </h3>
            <p class="font-secondary leading-relaxed text-gray-700">
              Kami menggunakan teknologi terkini dan terbaik untuk memastikan produk dan layanan yang kami berikan memiliki performa optimal dan dapat diandalkan.
            </p>
          </div>
        </div>
      </div>
    </section>
    @endif

    <!-- Partners Section -->
    <section class="bg-white px-6 py-20">
      <div class="mx-auto w-full max-w-6xl space-y-12">
        <h2 class="font-primary text-center text-3xl font-bold text-gray-900">
          Some of Our Partners and Clients
        </h2>
        <div
          class="flex flex-wrap items-center justify-center gap-12 md:gap-16"
        >
          <!-- Show images from Testimoni gambar field as partner logos -->
          @foreach($testimoni as $item)
          <div
            class="flex h-16 w-16 items-center justify-center rounded-lg overflow-hidden"
          >
            @if($item->gambar)
              <img 
                src="{{ asset('storage/testimoni/' . $item->gambar) }}" 
                alt="{{ $item->nama }}" 
                class="object-cover h-12 w-12 rounded"
                loading="lazy"
              >
            @else
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                class="h-10 w-10 text-blue-400"
              >
                <path
                  d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z"
                />
                <path
                  d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"
                />
              </svg>
            @endif
          </div>
          @endforeach
        </div>
      </div>
    </section>
@endsection
