<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection;

class CharCounterCache implements CharCounterInterface
{
    private CharCounterInterface $counter;
    private string $cacheFile;
    private array $cache = [];

    public function __construct(CharCounterInterface $counter, string $cacheFile = __DIR__ . '/../cache.json')
    {
        $this->counter = $counter;
        $this->cacheFile = $cacheFile;

        if (!file_exists($this->cacheFile)) {
            file_put_contents($this->cacheFile, json_encode([]));
        }

        $this->cache = $this->loadCache();
    }

    public function count(string $input): int
    {
        if ($this->isCached($input)) {
            return $this->get($input);
        }

        $uniqueCount = $this->counter->count($input);
        $this->set($input, $uniqueCount);

        return $uniqueCount;
    }

    private function loadCache(): array
    {
        $data = file_get_contents($this->cacheFile);
        if (!$data) {
            return [];
        }

        $decoded = json_decode($data, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function saveCache(): void
    {
        file_put_contents($this->cacheFile, json_encode($this->cache, JSON_PRETTY_PRINT));
    }

    private function isCached(string $key): bool
    {
        return isset($this->cache[$key]);
    }

    private function get(string $key): ?int
    {
        return $this->cache[$key] ?? null;
    }

    private function set(string $key, int $value): void
    {
        $this->cache[$key] = $value;
        $this->saveCache();
    }
}
