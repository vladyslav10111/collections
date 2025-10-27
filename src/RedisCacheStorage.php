<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection;

use Predis\Client as PredisClient;

class RedisCacheStorage implements CacheStorageInterface
{
    private PredisClient $redis;
    private int $ttl;

    public function __construct(
        array $params = ['scheme' => 'tcp', 'host' => 'host.docker.internal', 'port' => 6379],
        int $ttl = 3600
    ) {
        $this->redis = new PredisClient($params);
        $this->ttl = $ttl;
    }

    public function get(string $key): ?int
    {
        $hashed = md5($key);
        $value = $this->redis->get($hashed);
        return $value !== null ? (int)$value : null;
    }

    public function set(string $key, int $value): void
    {
        $hashed = md5($key);
        $this->redis->setex($hashed, $this->ttl, (string)$value);
    }
}
