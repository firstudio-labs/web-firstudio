<?php

namespace App\Helpers;

class YoutubeHelper
{
    public static function extractVideoId(?string $url): ?string
    {
        if (! $url || trim($url) === '') {
            return null;
        }

        $url = trim($url);

        if (preg_match('/(?:youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtube\.com\/watch\?.+&v=)([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }

        if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }

        if (preg_match('/(?:youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }

        return null;
    }

    public static function embedUrl(?string $url): ?string
    {
        $id = self::extractVideoId($url);

        if (! $id) {
            return null;
        }

        return 'https://www.youtube.com/embed/' . $id;
    }
}
