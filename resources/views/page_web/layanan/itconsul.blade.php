@extends('template_web.layout')

@section('content')
  <x-web.layanan-hero title-key="layanan.itconsul.hero.h1" subtitle-key="layanan.itconsul.hero.subtitle"
    default-title="Solusi Teknologi untuk Efisiensi Bisnis Anda" />

  <x-web.layanan-process prefix="itconsul" :dark="false" />

  @include('components.web.faq-section', [
    'subtitleKey' => 'faq.subtitle.itconsul',
    'items' => [
      ['questionKey' => 'faq.itconsul.q1', 'answerKey' => 'faq.itconsul.a1'],
      ['questionKey' => 'faq.itconsul.q2', 'answerKey' => 'faq.itconsul.a2'],
      ['questionKey' => 'faq.itconsul.q3', 'answerKey' => 'faq.itconsul.a3'],
      ['questionKey' => 'faq.itconsul.q4', 'answerKey' => 'faq.itconsul.a4'],
      ['questionKey' => 'faq.itconsul.q5', 'answerKey' => 'faq.itconsul.a5'],
      ['questionKey' => 'faq.itconsul.q6', 'answerKey' => 'faq.itconsul.a6'],
    ],
  ])
  <x-web.cta-consultation />
@endsection