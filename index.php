<?php

declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';

use Vladyslav10111\Collection\UniqueCharCounter;
use Vladyslav10111\Collection\CharCounterCache;

$cache = new CharCounterCache();

$counter = new UniqueCharCounter($cache);

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['text'] ?? '');

    if ($input !== '') {
        $uniqueCount = $counter->countUniqueChars($input);

        $result = "Unique characters: $uniqueCount";

    }
}

include __DIR__ . '/views/form.php';
