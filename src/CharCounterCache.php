<?php

namespace Vladyslav10111\Collection;

class CharCounterCache
{
    public string $cacheFile;

    public function __construct(string $cacheFile = __DIR__ . '/cache.json')
    {
        $this->cacheFile = $cacheFile;

        if (!file_exists($this->cacheFile)) {
            file_put_contents($this->cacheFile, json_encode([]));
        }
    }

    public function isCached(string $input): bool
    {
        $uniqueCharsCache = new CharCounterCache();

        $cache = $uniqueCharsCache->loadCache();

        if (isset($cache[$input])) {
            return true;
        } else {
            return false;
        }
    }

    public function loadCache(): array
    {
        $data = file_get_contents($this->cacheFile);

        if ($data) {
            $decoded = json_decode($data, true);
            if (is_array($decoded)) {
                return $decoded;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function saveCache(array $cache): void
    {
        file_put_contents($this->cacheFile, json_encode($cache, JSON_PRETTY_PRINT));
    }
}