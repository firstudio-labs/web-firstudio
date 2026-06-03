@props(['items' => []])

<nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500" aria-label="Breadcrumb">
  @foreach($items as $index => $item)
    @if($index > 0)
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="article-arrow-icon shrink-0" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
      </svg>
    @endif
    @if(!empty($item['current']))
      <span class="font-medium text-gray-900 {{ $item['class'] ?? '' }}" aria-current="page">{{ $item['label'] }}</span>
    @else
      <a href="{{ $item['url'] }}" class="transition hover:text-blue-600 {{ $item['class'] ?? '' }}"
        @if(!empty($item['i18n'])) data-i18n="{{ $item['i18n'] }}" @endif>{{ $item['label'] }}</a>
    @endif
  @endforeach
</nav>
