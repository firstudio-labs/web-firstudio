<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tentang extends Model
{
    use HasFactory;

    protected $fillable = [
        'gambar',
        'judul',
        'judul_en',
        'deskripsi',
        'deskripsi_en',
        'hitungan',
        'keterangan_hitungan',
        'keterangan_hitungan_en',
        'keterangan_memilih',
        'keterangan_memilih_en',
        'gambar_nilai',
        'keterangan_nilai',
        'keterangan_nilai_en',
    ];

    protected $casts = [
        'hitungan' => 'array',
        'keterangan_hitungan' => 'array',
        'keterangan_hitungan_en' => 'array',
    ];
}
