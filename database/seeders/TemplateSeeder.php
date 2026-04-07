<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriService = \App\Models\KategoriTemplate::where('nama_kategori', 'Service / Jasa')->first()->id;
        $kategoriExport = \App\Models\KategoriTemplate::where('nama_kategori', 'Produk Ekspor')->first()->id;
        $kategoriCompany = \App\Models\KategoriTemplate::where('nama_kategori', 'Company')->first()->id;

        $templates = [
            [
                'judul' => 'Muslim Organizations - Building and Management',
                'deskripsi' => 'Template profesional untuk organisasi muslim dan pembangunan masjid.',
                'gambar' => 'muslim_org.png',
                'link' => '#',
                'jumlah_pemilih' => 56,
                'kategori_template_id' => $kategoriService,
            ],
            [
                'judul' => 'Global Standard Briquette Products',
                'deskripsi' => 'Desain industri untuk produk briket dan arang ekspor.',
                'gambar' => 'briquette.png',
                'link' => '#',
                'jumlah_pemilih' => 67,
                'kategori_template_id' => $kategoriExport,
            ],
            [
                'judul' => 'Global Company - Empowering Growth Through Collaboration',
                'deskripsi' => 'Template corporate modern untuk perusahaan skala global.',
                'gambar' => 'corporate.png',
                'link' => '#',
                'jumlah_pemilih' => 76,
                'kategori_template_id' => $kategoriCompany,
            ],
            [
                'judul' => 'Padel - More Than A Game It\'s A Movement',
                'deskripsi' => 'Desain enerjik untuk klub olahraga dan komunitas Padel.',
                'gambar' => 'padel.png',
                'link' => '#',
                'jumlah_pemilih' => 109,
                'kategori_template_id' => $kategoriService,
            ],
            [
                'judul' => 'Mobile App Landing - Increase Productivity',
                'deskripsi' => 'Landing page modern untuk aplikasi mobile dan SaaS.',
                'gambar' => 'app_landing.png',
                'link' => '#',
                'jumlah_pemilih' => 179,
                'kategori_template_id' => $kategoriService,
            ],
            [
                'judul' => 'Go Travel! Enjoy Fast, Safe and Comfortable Travel!',
                'deskripsi' => 'Template agen perjalanan dengan fitur eksplorasi destinasi.',
                'gambar' => 'travel.png',
                'link' => '#',
                'jumlah_pemilih' => 66,
                'kategori_template_id' => $kategoriService,
            ],
        ];

        foreach ($templates as $template) {
            \App\Models\Template::create($template);
        }
    }
}
