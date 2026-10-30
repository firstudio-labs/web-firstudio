@props(['titleKey', 'defaultTitle' => '', 'subtitleKey' => 'rb.layanan.hero.subtitle'])

<x-web.page-hero :title="$defaultTitle" :title-i18n="$titleKey" crumb="Solusi" crumb-i18n="nav.solusi"
  subtitle="Konsultasi awal gratis, lalu kami kerjakan dari rancangan sampai sistem live."
  :subtitle-i18n="$subtitleKey" />
