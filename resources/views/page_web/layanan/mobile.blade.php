@extends('template_web.layout')

@section('content')
  <x-web.layanan-hero title-key="layanan.mobile.hero.h1" subtitle-key="layanan.mobile.hero.subtitle"
    default-title="Kembangkan Aplikasi Mobile untuk Bisnis Anda" />

  <x-web.layanan-process prefix="mobile" :dark="false" />

  @include('components.web.faq-section', [
    'subtitleKey' => 'faq.subtitle.mobile',
    'items' => [
      ['questionKey' => 'faq.mobile.q1', 'answerKey' => 'faq.mobile.a1'],
      ['questionKey' => 'faq.mobile.q2', 'answerKey' => 'faq.mobile.a2'],
      ['questionKey' => 'faq.mobile.q3', 'answerKey' => 'faq.mobile.a3'],
      ['questionKey' => 'faq.mobile.q4', 'answerKey' => 'faq.mobile.a4'],
      ['questionKey' => 'faq.mobile.q5', 'answerKey' => 'faq.mobile.a5'],
      ['questionKey' => 'faq.mobile.q6', 'answerKey' => 'faq.mobile.a6'],
    ],
  ])
  <x-web.cta-consultation />
@endsection 