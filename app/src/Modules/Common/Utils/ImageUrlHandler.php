<?php

namespace Modules\Common\Utils;

final class ImageUrlHandler
{
    public function __invoke(string $imageUrl): string
    {
        $imageUrl = $this->sanitizeImageUrl($imageUrl);

        if ($this->isFullUrl($imageUrl)) {
            return $imageUrl;
        }

        return config('media_service_url').'/'.$imageUrl;
    }

    private function isFullUrl(string $imageUrl): bool
    {
        return filter_var($imageUrl, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
    }

    private function sanitizeImageUrl(string $imageUrl): string
    {
        return filter_var(trim($imageUrl, " \t\n\r\0\x0B/\\"), FILTER_SANITIZE_URL);
    }
}
