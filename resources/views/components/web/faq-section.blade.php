@props([
  'subtitleKey' => 'faq.subtitle.website',
  'items' => [],
])

<section id="faq" class="rb-section bg-white px-6 text-ink">
  <div class="page-container grid gap-12 lg:grid-cols-[1fr_1.9fr]">
    <div class="space-y-4">
      <p class="rb-eyebrow" data-i18n="faq.label">FAQ</p>
      <h2 class="rb-h2" data-i18n="faq.title">Pertanyaan yang Sering Diajukan</h2>
      <p class="rb-lead max-w-xs" data-i18n="{{ $subtitleKey }}">Pertanyaan yang sering diajukan</p>
    </div>

    <div class="border-b border-line">
      @foreach ($items as $index => $item)
        <div class="faq-item border-t border-line">
          <button class="faq-button flex w-full items-center justify-between gap-6 py-5 text-left" data-faq="{{ $index + 1 }}"
            type="button">
            @if (!empty($item['questionKey']))
              <span class="text-sm font-semibold text-navy" data-i18n="{{ $item['questionKey'] }}"></span>
            @else
              <span class="text-sm font-semibold text-navy">{{ $item['question'] ?? '' }}</span>
            @endif
            <svg class="h-4 w-4 flex-shrink-0 text-brand transition-transform duration-200" data-rotate="45" fill="none"
              stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
            </svg>
          </button>
          <div class="faq-content hidden pb-5 pr-10">
            <div class="text-xs leading-relaxed text-muted">
              @if (!empty($item['answerKey']))
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
