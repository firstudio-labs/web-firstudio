@props([
  'subtitleKey' => 'faq.subtitle.website',
  'items' => [],
])

<section id="faq" class="bg-gray-50 px-6 py-20 text-gray-900">
  <div class="mx-auto w-full max-w-4xl space-y-12">
    <div class="text-center space-y-4">
      <h2 class="font-primary text-3xl font-bold md:text-4xl" data-i18n="faq.title">
        Pertanyaan yang Sering Diajukan
      </h2>
      <p class="font-secondary text-lg text-gray-600" data-i18n="{{ $subtitleKey }}">
        Pertanyaan yang sering diajukan
      </p>
    </div>

    <div class="space-y-4">
      @foreach($items as $index => $item)
        <div class="faq-item rounded-2xl border border-gray-200 bg-white overflow-hidden">
          <button
            class="faq-button flex w-full items-center justify-between p-6 text-left transition"
            data-faq="{{ $index + 1 }}"
            type="button"
          >
            @if(!empty($item['questionKey']))
              <span class="font-semibold text-lg" data-i18n="{{ $item['questionKey'] }}"></span>
            @else
              <span class="font-semibold text-lg">{{ $item['question'] ?? '' }}</span>
            @endif
            <svg class="h-6 w-6 flex-shrink-0 text-gray-500 transition-transform duration-200" fill="none"
              stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="faq-content hidden px-6 pb-6">
            <div class="text-gray-600 leading-relaxed">
              @if(!empty($item['answerKey']))
                <div data-i18n-html="{{ $item['answerKey'] }}"></div>
              @else
                {!! $item['answer'] ?? '' !!}
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
