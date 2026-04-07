<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'link',
        'jumlah_pemilih',
        'kategori_template_id'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriTemplate::class, 'kategori_template_id');
    }
}
