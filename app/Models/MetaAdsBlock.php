<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MetaAdsBlock extends Model
{
    public const TYPE_IMAGE = 'image';

    public const TYPE_BUTTON = 'button';

    public const TYPE_YOUTUBE = 'youtube';

    protected $fillable = [
        'type',
        'sort_order',
        'image_path',
        'button_label',
        'button_url',
        'youtube_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    public function imageUrl(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        return asset('storage/meta-ads/' . $this->image_path);
    }
}
