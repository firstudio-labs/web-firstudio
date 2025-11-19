<?php

namespace App\Services;

use App\Models\AiTokenUsage;
use Illuminate\Support\Facades\Log;

class TokenUsageService
{
    public const DEFAULT_DAILY_LIMIT = 6;

    public function getTodayUsage(int $userId): AiTokenUsage
    {
        $usage = AiTokenUsage::forToday($userId);
        // Pastikan daily_limit di-set jika null/0
        if (!$usage->daily_limit) {
            $usage->daily_limit = self::DEFAULT_DAILY_LIMIT;
            $usage->save();
        }
        return $usage;
    }

    public function getDailyLimit(int $userId): int
    {
        $usage = $this->getTodayUsage($userId);
        return $usage->daily_limit;
    }

    public function getRemainingTokens(int $userId): int
    {
        $usage = $this->getTodayUsage($userId);
        return max(0, $usage->daily_limit - $usage->tokens_used);
    }

    public function canUse(int $userId, int $tokens = 1): bool
    {
        $usage = $this->getTodayUsage($userId);
        return ($usage->tokens_used + $tokens) <= $usage->daily_limit;
    }

    public function increment(int $userId, string $actionType, int $tokens = 1, array $meta = []): AiTokenUsage
    {
        $usage = $this->getTodayUsage($userId);
        $usage->tokens_used = ($usage->tokens_used ?? 0) + $tokens;

        $details = $usage->usage_details ?? [];
        $details[] = [
            'at' => now()->toDateTimeString(),
            'action' => $actionType,
            'tokens' => $tokens,
            'meta' => $meta,
        ];
        $usage->usage_details = $details;
        $usage->save();
        return $usage;
    }
}
