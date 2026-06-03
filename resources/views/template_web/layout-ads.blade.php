@php
    $theme = $theme ?? \App\Support\MetaAdsTheme::defaults();
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>{{ $pageTitle ?? 'Firstudio' }}</title>
    @if (!empty($pageDescription))
        <meta name="description" content="{{ $pageDescription }}" />
    @endif

    @include('components.web.meta-pixel', ['layoutContext' => 'ads'])

    @vite(['resources/css/app.css'])
    <style>
        .meta-ads-page {
            --meta-ads-bg: {{ $theme['bg'] }};
            --meta-ads-text: {{ $theme['text'] }};
            --meta-ads-btn-bg: {{ $theme['button'] }};
            background-color: var(--meta-ads-bg);
            color: var(--meta-ads-text);
        }
    </style>
    @yield('head')
</head>

<body class="meta-ads-page antialiased">
    @yield('content')
</body>

</html>
