<?php

declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';

use Vladyslav10111\Collection\UniqueCharCounter;
use Vladyslav10111\Collection\RedisCharCounterCache;

$counter = new UniqueCharCounter();
$cache = new RedisCharCounterCache($counter);

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['text'] ?? '');

    if ($input !== '') {
        $uniqueCount = $cache->count($input);

        $result = "Unique characters: $uniqueCount";

    }
}

include __DIR__ . '/views/form.php';
