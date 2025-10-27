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
        $hashed = md5($key);
        return $this->cache[$hashed] ?? null;
    }

    public function set(string $key, int $value): void
    {
        $hashed = md5($key);
        $this->cache[$hashed] = $value;
        file_put_contents($this->cacheFile, json_encode($this->cache, JSON_PRETTY_PRINT));
    }
}
