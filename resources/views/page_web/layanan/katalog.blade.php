@extends('template_web.layout')

@section('content')
<section class="bg-gray-50 px-6 py-20 text-gray-900 min-h-screen">
    <div class="mx-auto w-full max-w-7xl space-y-12">
        <!-- Header -->
        <div class="text-center space-y-4">
            <h1 class="font-primary text-4xl font-bold md:text-5xl">Katalog Template Website</h1>
            <p class="font-secondary text-lg text-gray-600 max-w-2xl mx-auto">
                Pilih desain yang paling sesuai dengan identitas bisnis Anda. Semua template didesain profesional, responsif, dan siap kami kustomisasi.
            </p>
        </div>

        <!-- Filters -->
        <div class="flex flex-wrap justify-center gap-3">
            <button class="filter-btn active" data-category="semua">Semua</button>
            @foreach($categories as $category)
                @if($category->templates_count > 0)
                    <button class="filter-btn" data-category="{{ \Illuminate\Support\Str::slug($category->nama_kategori) }}">
                        {{ $category->nama_kategori }}
                    </button>
                @endif
            @endforeach
        </div>

        <!-- Grid -->
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3" id="template-grid">
            @foreach($templates as $template)
                <div class="template-card h-full" data-category="{{ \Illuminate\Support\Str::slug($template->kategori->nama_kategori) }}">
                    <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:shadow-xl h-full flex flex-col">
                        <div class="aspect-[16/10] overflow-hidden flex-shrink-0">
                            <img src="{{ asset('storage/template/' . $template->gambar) }}" alt="{{ $template->judul }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="font-primary text-xl font-bold mb-2">{{ $template->judul }}</h3>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $template->deskripsi }}</p>
                            
                            <div class="mt-auto pt-4">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded">{{ $template->kategori->nama_kategori }}</span>
                                    <p class="text-xs text-gray-500">{{ $template->jumlah_pemilih }} orang memilih ini</p>
                                </div>
                                @if($template->link)
                                    <a href="{{ $template->link }}" target="_blank" class="block w-full text-center text-sm font-bold text-gray-900 border-t pt-4 hover:text-blue-600 transition">Lihat Preview</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- CTA -->
        <div class="text-center pt-12">
            <p class="font-secondary text-gray-600 mb-6">Penasaran dengan desain lainnya atau ingin request custom?</p>
            <a href="{{ route('web.contact.index') }}" class="btn btn-primary inline-flex items-center gap-2">
                <i data-lucide="message-square" class="h-5 w-5"></i>
                Konsultasikan Pilihan Anda
            </a>
        </div>
    </div>
</section>

<style>
    .filter-btn {
        @apply px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-600 transition;
    }
    .filter-btn:hover {
        @apply border-blue-500 text-blue-600;
    }
    .filter-btn.active {
        @apply bg-blue-600 border-blue-600 text-white;
    }

    .template-card {
        transition: all 0.3s ease;
    }

    .template-card.hidden {
        display: none;
    }
</style>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const templateCards = document.querySelectorAll('.template-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Update active button
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const category = btn.getAttribute('data-category');

                // Filter cards
                templateCards.forEach(card => {
                    if (category === 'semua' || card.getAttribute('data-category') === category) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            });
        });
    });
</script>
@endsection
