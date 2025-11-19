<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'gambar',
        'deskripsi',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($layanan) {
            $layanan->slug = Str::slug($layanan->judul);
        });
    }
}
