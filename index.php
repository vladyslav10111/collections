<?php

require __DIR__ . '/vendor/autoload.php';

use Vladyslav10111\Collection\UniqueCharCounter;
use Vladyslav10111\Collection\CharCounterCache;

$counter = new UniqueCharCounter();
$cache = new CharCounterCache();
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['text'] ?? '');

    $isCached = $cache->isCached($input);

    if ($input !== '') {
        if ($isCached) {
            $result = "Taken from cache: " . $counter->countUniqueChars($input);
        } else {
            $result = "Unique characters: " . $counter->countUniqueChars($input);
        }

    }
}

include __DIR__ . '/views/form.php';
