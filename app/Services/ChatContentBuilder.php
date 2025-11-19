<?php

namespace App\Services;

use App\Models\Artikel;
use App\Models\ChatbotFaq;
use App\Models\Layanan;
use App\Models\Produk;
use App\Models\Tentang;
use Illuminate\Support\Str;

class ChatContentBuilder
{
    public function buildContext(): string
    {
        $sections = [];

        if ($tentang = Tentang::latest()->first()) {
            $sections[] = 'Profil Perusahaan: ' . Str::limit(strip_tags($tentang->deskripsi ?? ''), 400);
        }

        $layanans = Layanan::query()
            ->select('judul', 'deskripsi')
            ->latest()
            ->take(5)
            ->get();

        if ($layanans->isNotEmpty()) {
            $services = $layanans->map(function ($layanan) {
                return '- ' . $layanan->judul . ': ' . Str::limit(strip_tags($layanan->deskripsi ?? ''), 200);
            })->implode("\n");

            $sections[] = "Layanan utama:\n{$services}";
        }

        $produk = Produk::query()
            ->select('judul', 'deskripsi')
            ->latest()
            ->take(5)
            ->get();

        if ($produk->isNotEmpty()) {
            $portfolio = $produk->map(function ($item) {
                return '- ' . $item->judul . ': ' . Str::limit(strip_tags($item->deskripsi ?? ''), 180);
            })->implode("\n");

            $sections[] = "Contoh proyek:\n{$portfolio}";
        }

        $artikels = Artikel::query()
            ->select('judul', 'isi')
            ->latest()
            ->take(3)
            ->get();

        if ($artikels->isNotEmpty()) {
            $posts = $artikels->map(function ($artikel) {
                return '- ' . $artikel->judul . ': ' . Str::limit(strip_tags($artikel->isi ?? ''), 160);
            })->implode("\n");

            $sections[] = "Artikel terbaru:\n{$posts}";
        }

        $faqs = ChatbotFaq::query()
            ->where('is_active', true)
            ->latest()
            ->take(10)
            ->get();

        if ($faqs->isNotEmpty()) {
            $faqText = $faqs->map(function ($faq) {
                return 'Q: ' . $faq->question . "\nA: " . Str::limit(strip_tags($faq->answer), 220);
            })->implode("\n\n");

            $sections[] = "FAQ internal:\n{$faqText}";
        }

        return Str::limit(implode("\n\n", array_filter($sections)), 2200);
    }
}

