<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Produk Ekspor',
            'Agrikultur',
            'Craft',
            'Company',
            'Otomotif',
            'Restaurant',
            'Service / Jasa',
        ];

        foreach ($categories as $category) {
            \App\Models\KategoriTemplate::updateOrCreate(['nama_kategori' => $category]);
        }
    }
}
