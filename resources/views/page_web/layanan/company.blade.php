@extends('template_web.layout')

@section('content')
  <x-web.layanan-hero title-key="layanan.company.hero.h1"
    default-title="Buat Company Profile Profesional untuk Bisnis Anda" />

  <x-web.layanan-process prefix="company" :dark="false" />

  @include('components.web.faq-section', [
    'subtitleKey' => 'faq.subtitle.company',
    'items' => [
      ['questionKey' => 'faq.company.q1', 'answerKey' => 'faq.company.a1'],
      ['questionKey' => 'faq.company.q2', 'answerKey' => 'faq.company.a2'],
      ['questionKey' => 'faq.company.q3', 'answerKey' => 'faq.company.a3'],
      ['questionKey' => 'faq.company.q4', 'answerKey' => 'faq.company.a4'],
      ['questionKey' => 'faq.company.q5', 'answerKey' => 'faq.company.a5'],
      ['questionKey' => 'faq.company.q6', 'answerKey' => 'faq.company.a6'],
    ],
  ])
  <x-web.cta-consultation />
@endsection 