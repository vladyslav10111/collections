<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection;

class UniqueCharCounter
{
    public function calculateUniqueChars(string $input): int
    {
        $length = mb_strlen($input, 'UTF-8');
        $chars = [];

        for ($i = 0; $i < $length; $i++) {
            $chars[] = mb_substr($input, $i, 1, 'UTF-8');
        }

        return count(array_count_values($chars));
    }
}
