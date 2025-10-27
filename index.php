<?php

declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';

use Vladyslav10111\Collection\UniqueCharCounter;
use Vladyslav10111\Collection\CharCounterCache;
use Vladyslav10111\Collection\FileCacheStorage;
use Vladyslav10111\Collection\RedisCacheStorage;

$counter = new UniqueCharCounter();

$useRedis = true;

if ($useRedis) {
    $storage = new RedisCacheStorage([
        'scheme' => 'tcp',
        'host' => 'host.docker.internal',
        'port' => 6379,
    ]);
} else {
    $storage = new FileCacheStorage(__DIR__ . '/cache.json');
}

$cache = new CharCounterCache($counter, $storage);

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['text'] ?? '');

    if ($input !== '') {
        $uniqueCount = $cache->count($input);
        $result = "Unique characters: $uniqueCount";
    }
}

include __DIR__ . '/views/form.php';
