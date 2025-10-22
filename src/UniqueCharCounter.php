<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection;

class UniqueCharCounter
{
    private CharCounterCache $cache;

    public function __construct(CharCounterCache $cache)
    {
        $this->cache = $cache;
    }

    public function calculateUniqueChars(string $input): int
    {
        $length = mb_strlen($input, 'UTF-8');
        $chars = [];

        for ($i = 0; $i < $length; $i++) {
            $chars[] = mb_substr($input, $i, 1, 'UTF-8');
        }

        return count(array_count_values($chars));
    }

    public function countUniqueChars(string $input): int
    {
        $cachedValue = $this->cache->get($input);
        if ($cachedValue !== null) {
            return $cachedValue;
        }

        $uniqueCount = $this->calculateUniqueChars($input);

        $this->cache->set($input, $uniqueCount);

        return $uniqueCount;
    }
}
