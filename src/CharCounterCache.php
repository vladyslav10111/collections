<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection;

class CharCounterCache implements CharCounterInterface
{
    private CharCounterInterface $counter;
    private CacheStorageInterface $storage;

    public function __construct(CharCounterInterface $counter, CacheStorageInterface $storage)
    {
        $this->counter = $counter;
        $this->storage = $storage;
    }

    public function count(string $input): int
    {
        $cached = $this->storage->get($input);
        if ($cached !== null) {
            return $cached;
        }

        $uniqueCount = $this->counter->count($input);
        $this->storage->set($input, $uniqueCount);

        return $uniqueCount;
    }
}
