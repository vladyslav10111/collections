<?php

namespace Vladyslav10111\Collection;

class UniqueCharCounter
{

    public function countUniqueChars(string $input): int
    {

        $uniqueCharsCache = new CharCounterCache();

        $length = mb_strlen($input, 'UTF-8');
        $chars = [];
        for ($i = 0; $i < $length; $i++) {
            $chars[] = mb_substr($input, $i, 1, 'UTF-8');
        }

        $counts = array_count_values($chars);
        $uniqueCount = count($counts);

        $cache[$input] = $uniqueCount;
        $uniqueCharsCache->saveCache($cache);

        return $uniqueCount;
    }


}
