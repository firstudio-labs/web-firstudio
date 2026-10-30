@extends('template_web.layout')

@section('content')
  <x-web.layanan-hero title-key="layanan.outsourcing.hero.h1" subtitle-key="layanan.outsourcing.hero.subtitle"
    default-title="Tim Ekstensi Profesional untuk Proyek Anda" />

  <x-web.layanan-process prefix="outsourcing" :dark="false" />

  @include('components.web.faq-section', [
    'subtitleKey' => 'faq.subtitle.outsourcing',
    'items' => [
      ['questionKey' => 'faq.outsourcing.q1', 'answerKey' => 'faq.outsourcing.a1'],
      ['questionKey' => 'faq.outsourcing.q2', 'answerKey' => 'faq.outsourcing.a2'],
      ['questionKey' => 'faq.outsourcing.q3', 'answerKey' => 'faq.outsourcing.a3'],
      ['questionKey' => 'faq.outsourcing.q4', 'answerKey' => 'faq.outsourcing.a4'],
      ['questionKey' => 'faq.outsourcing.q5', 'answerKey' => 'faq.outsourcing.a5'],
      ['questionKey' => 'faq.outsourcing.q6', 'answerKey' => 'faq.outsourcing.a6'],
    ],
  ])
  <x-web.cta-consultation />
@endsection