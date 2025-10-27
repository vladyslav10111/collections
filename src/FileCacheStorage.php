<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection;
class FileCacheStorage implements CacheStorageInterface
{
    private string $cacheFile;
    private array $cache = [];

    public function __construct(string $cacheFile = __DIR__ . '/../cache.json')
    {
        $this->cacheFile = $cacheFile;
        if (!file_exists($cacheFile)) {
            file_put_contents($cacheFile, json_encode([]));
        }
        $this->cache = json_decode(file_get_contents($cacheFile), true) ?? [];
    }

    public function get(string $key): ?int
    {
        return $this->cache[$key] ?? null;
    }

    public function set(string $key, int $value): void
    {
        $this->cache[$key] = $value;
        file_put_contents($this->cacheFile, json_encode($this->cache, JSON_PRETTY_PRINT));
    }
}