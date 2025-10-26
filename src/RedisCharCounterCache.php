<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection;

use Predis\Client as PredisClient;
use Predis\Connection\ConnectionException;

class RedisCharCounterCache implements CharCounterInterface
{
    private CharCounterInterface $counter;
    private ?PredisClient $redis = null;
    private string $prefix = 'charcount:';
    private int $ttl = 3600;
    private array $connectionParams;

    public function __construct(CharCounterInterface $counter, array $connectionParams = ['scheme' => 'tcp', 'host' => 'host.docker.internal', 'port' => 6379])
    {
        $this->counter = $counter;
        $this->connectionParams = $connectionParams;
    }

    public function getRedis(): ?PredisClient
    {
        if ($this->redis === null) {
            try {
                $this->redis = new PredisClient($this->connectionParams);
            } catch (\Exception $e) {
                $this->redis = null;
            }
        }
        return $this->redis;
    }

    public function count(string $input): int
    {
        $key = $this->prefix . md5($input);
        $redis = $this->getRedis();

        if ($redis !== null) {
            try {
                $cached = $redis->get($key);
                if ($cached !== null) {
                    return (int)$cached;
                }
            } catch (ConnectionException $e) {
                $redis = null;
            }
        }

        $uniqueCount = $this->counter->count($input);

        if ($redis !== null) {
            try {
                $redis->setex($key, $this->ttl, (string)$uniqueCount);
            } catch (ConnectionException $e) {

            }
        }

        return $uniqueCount;
    }
}
