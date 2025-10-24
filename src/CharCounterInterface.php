<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection;

interface CharCounterInterface
{
    public function count(string $input): int;
}
