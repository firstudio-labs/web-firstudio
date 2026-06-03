<?php

namespace App\Support;

use App\Models\Setting;

class MetaAdsTheme
{
    public const DEFAULT_BG = '#000000';

    public const DEFAULT_BUTTON = '#3b82f6';

    public const DEFAULT_TEXT = '#ffffff';

    public static function defaults(): array
    {
        return [
            'bg' => self::DEFAULT_BG,
            'button' => self::DEFAULT_BUTTON,
            'text' => self::DEFAULT_TEXT,
        ];
    }

    public static function fromDatabase(): array
    {
        return [
            'bg' => self::normalizeHex(
                Setting::where('key', 'meta_ads_bg_color')->value('value'),
                self::DEFAULT_BG
            ),
            'button' => self::normalizeHex(
                Setting::where('key', 'meta_ads_button_color')->value('value'),
                self::DEFAULT_BUTTON
            ),
            'text' => self::normalizeHex(
                Setting::where('key', 'meta_ads_text_color')->value('value'),
                self::DEFAULT_TEXT
            ),
        ];
    }

    public static function normalizeHex(?string $value, string $default): string
    {
        if (! $value || ! is_string($value)) {
            return strtoupper($default);
        }

        $value = trim($value);

        if (! preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $value)) {
            return strtoupper($default);
        }

        if (strlen($value) === 4) {
            $r = $value[1];
            $g = $value[2];
            $b = $value[3];
            $value = '#' . $r . $r . $g . $g . $b . $b;
        }

        return strtoupper($value);
    }
}
