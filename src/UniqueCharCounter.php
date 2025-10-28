<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection;

class UniqueCharCounter implements CharCounterInterface
{
    public function count(string $input): int
    {
        $length = mb_strlen($input, 'UTF-8');
        $chars = [];

        for ($i = 0; $i < $length; $i++) {
            $chars[] = mb_substr($input, $i, 1, 'UTF-8');
        }

        $counts = array_count_values($chars);

        $uniqueChars = array_filter($counts, fn($count) => $count === 1);

        return count($uniqueChars);
    }
}
