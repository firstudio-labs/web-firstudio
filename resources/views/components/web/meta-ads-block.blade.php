@php
    use App\Helpers\YoutubeHelper;
@endphp

<div class="meta-ads-block w-full">
    @if ($block->type === \App\Models\MetaAdsBlock::TYPE_IMAGE && $block->image_path)
        <img src="{{ $block->imageUrl() }}" alt="" class="w-full h-auto rounded-lg" loading="lazy" decoding="async">
    @elseif ($block->type === \App\Models\MetaAdsBlock::TYPE_BUTTON && $block->button_label && $block->button_url)
        <a href="{{ $block->button_url }}" class="btn meta-ads-btn btn-block w-full text-center" target="_blank"
            rel="noopener noreferrer">
            {{ $block->button_label }}
        </a>
    @elseif ($block->type === \App\Models\MetaAdsBlock::TYPE_YOUTUBE && $block->youtube_url)
        @php $embedUrl = YoutubeHelper::embedUrl($block->youtube_url); @endphp
        @if ($embedUrl)
            <div class="aspect-video w-full overflow-hidden rounded-lg">
                <iframe class="h-full w-full" src="{{ $embedUrl }}" title="YouTube video"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen loading="lazy"></iframe>
            </div>
        @endif
    @endif
</div>
