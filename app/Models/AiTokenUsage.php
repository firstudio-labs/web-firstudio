<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AiTokenUsage extends Model
{
    use HasFactory;

    protected $table = 'ai_token_usage';

    protected $fillable = [
        'user_id',
        'usage_date',
        'tokens_used',
        'daily_limit',
        'usage_details',
    ];

    protected $casts = [
        'usage_date' => 'date',
        'usage_details' => 'array',
    ];

    public static function forToday(int $userId): self
    {
        $today = now()->toDateString();

        /** @var self $record */
        $record = static::firstOrCreate(
            ['user_id' => $userId, 'usage_date' => $today],
            [
                'tokens_used' => 0,
                'daily_limit' => 6,
                'usage_details' => [],
            ]
        );

        return $record;
    }
}
