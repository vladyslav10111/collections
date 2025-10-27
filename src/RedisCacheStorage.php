<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection;

use Predis\Client as PredisClient;

class RedisCacheStorage implements CacheStorageInterface
{
    private PredisClient $redis;
    private int $ttl = 3600;

    public function __construct(array $params = ['scheme' => 'tcp', 'host' => 'host.docker.internal', 'port' => 6379])
    {
        $this->redis = new PredisClient($params);
    }

    public function get(string $key): ?int
    {
        $value = $this->redis->get($key);
        return $value !== null ? (int)$value : null;
    }

    public function set(string $key, int $value): void
    {
        $this->redis->setex($key, $this->ttl, (string)$value);
    }
}