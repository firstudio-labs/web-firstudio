<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori'];

    public function templates()
    {
        return $this->hasMany(Template::class, 'kategori_template_id');
    }
}
