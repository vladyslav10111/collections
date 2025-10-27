<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection;
interface CacheStorageInterface
{
    public function get(string $key): ?int;
    public function set(string $key, int $value): void;
}