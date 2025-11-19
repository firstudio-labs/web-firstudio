<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = [
        'gambar',
        'keterangan',
        'kategori_gambar_id',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($galeri) {
            $galeri->slug = Str::slug($galeri->keterangan);
        });
    }

    public function kategoriGambar()
    {
        return $this->belongsTo(KategoriGambar::class, 'kategori_gambar_id');
    }
}
