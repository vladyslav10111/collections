<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection\Tests;

use PHPUnit\Framework\TestCase;
use Vladyslav10111\Collection\CharCounterCache;
use Vladyslav10111\Collection\CharCounterInterface;

class CharCounterCacheTest extends TestCase
{
    private string $cacheFile;

    protected function setUp(): void
    {
        $this->cacheFile = __DIR__ . '/test_cache.json';
        if (file_exists($this->cacheFile)) {
            unlink($this->cacheFile);
        }
    }

    protected function tearDown(): void
    {
        if (file_exists($this->cacheFile)) {
            unlink($this->cacheFile);
        }
    }

    public function testReturnsCachedValueWithoutRecalculating(): void
    {
        $cachedData = ['hello' => 4];
        file_put_contents($this->cacheFile, json_encode($cachedData));

        $mockCounter = $this->createMock(CharCounterInterface::class);

        $mockCounter->expects($this->never())->method('count');

        $cache = new CharCounterCache($mockCounter, $this->cacheFile);
        $result = $cache->count('hello');

        $this->assertSame(4, $result);
    }

    public function testCalculatesAndSavesToCacheIfNotCached(): void
    {
        $mockCounter = $this->createMock(CharCounterInterface::class);
        $mockCounter->expects($this->once())
            ->method('count')
            ->with('hello')
            ->willReturn(4);

        $cache = new CharCounterCache($mockCounter, $this->cacheFile);
        $result = $cache->count('hello');

        $this->assertSame(4, $result);

        $data = json_decode(file_get_contents($this->cacheFile), true);
        $this->assertSame(['hello' => 4], $data);
    }

    public function testCreatesCacheFileIfNotExists(): void
    {
        $mockCounter = $this->createMock(CharCounterInterface::class);
        $mockCounter->expects($this->once())->method('count')->willReturn(4);

        $cache = new CharCounterCache($mockCounter, $this->cacheFile);
        $cache->count('hello');

        $this->assertFileExists($this->cacheFile);
    }
}
