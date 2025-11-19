<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tim extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'gambar',
        'posisi',
        'instagram',
        'linkedin',
        'facebook',
        'whatsapp',
        'quote',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($tim) {
            $tim->slug = Str::slug($tim->nama);
        });
    }
}
