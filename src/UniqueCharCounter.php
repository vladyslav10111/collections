<?php

namespace Vladyslav10111\Collection;

class UniqueCharCounter
{
    private string $cacheFile;

    public function __construct(string $cacheFile = __DIR__ . '/cache.json')
    {
        $this->cacheFile = $cacheFile;

        if (!file_exists($this->cacheFile)) {
            file_put_contents($this->cacheFile, json_encode([]));
        }
    }

    public function countUniqueChars(string $input): string
    {
        $cache = $this->loadCache();

        if (isset($cache[$input])) {
            return "Taken from cache: " . $cache[$input];
        }

        $length = mb_strlen($input, 'UTF-8');
        $chars = [];
        for ($i = 0; $i < $length; $i++) {
            $chars[] = mb_substr($input, $i, 1, 'UTF-8');
        }

        $counts = array_count_values($chars);
        $uniqueCount = count($counts);

        $cache[$input] = $uniqueCount;
        $this->saveCache($cache);

        return  "Unique characters: " . $uniqueCount;
    }

    private function loadCache(): array
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

    private function saveCache(array $cache): void
    {
        file_put_contents($this->cacheFile, json_encode($cache, JSON_PRETTY_PRINT));
    }
}
