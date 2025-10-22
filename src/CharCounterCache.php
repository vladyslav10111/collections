<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection;

class CharCounterCache
{
    private string $cacheFile;
    private array $cache = [];

    public function __construct(string $cacheFile = __DIR__ . '/cache.json')
    {
        $this->cacheFile = $cacheFile;

        if (!file_exists($this->cacheFile)) {
            file_put_contents($this->cacheFile, json_encode([]));
        }

        $this->cache = $this->loadCache();
    }

    private function loadCache(): array
    {
        $data = file_get_contents($this->cacheFile);

        if (!$data) {
            return [];
        }

        $decoded = json_decode($data, true);

        if (is_array($decoded)) {
            return $decoded;
        }

        return [];
    }


    private function saveCache(): void
    {
        file_put_contents($this->cacheFile, json_encode($this->cache, JSON_PRETTY_PRINT));
    }

    public function isCached(string $key): bool
    {
        return isset($this->cache[$key]);
    }

    public function get(string $key): ?int
    {
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }

        return null;
    }

    public function set(string $key, int $value): void
    {
        $this->cache[$key] = $value;
        $this->saveCache();
    }
}
