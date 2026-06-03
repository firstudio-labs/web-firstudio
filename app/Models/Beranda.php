<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beranda extends Model
{
    use HasFactory;
    protected $fillable = [
    'judul_utama',
    'judul_utama_en',
    'gambar_utama',
    'slogan',
    'slogan_en',
    'gambar_sekunder',
    'judul_sekunder',
    'judul_sekunder_en',
    'keterangan',
    'keterangan_en',
    ];
}
