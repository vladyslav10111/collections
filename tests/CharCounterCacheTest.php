<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection\Tests;

use PHPUnit\Framework\TestCase;
use Vladyslav10111\Collection\CharCounterCache;
use Vladyslav10111\Collection\CharCounterInterface;
use Vladyslav10111\Collection\CacheStorageInterface;


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
        $storageMock = $this->createMock(CacheStorageInterface::class);
        $storageMock->expects($this->once())
            ->method('get')
            ->with('hello')
            ->willReturn(4);

        $counterMock = $this->createMock(CharCounterInterface::class);
        $counterMock->expects($this->never())
            ->method('count');

        $cache = new CharCounterCache($counterMock, $storageMock);

        $result = $cache->count('hello');

        $this->assertSame(4, $result);
    }

    public function testCalculatesAndSavesToCacheIfNotCached(): void
    {
        $storageMock = $this->createMock(CacheStorageInterface::class);
        $storageMock->expects($this->once())
            ->method('get')
            ->with('hello')
            ->willReturn(null);

        $storageMock->expects($this->once())
            ->method('set')
            ->with('hello', 4);

        $counterMock = $this->createMock(CharCounterInterface::class);
        $counterMock->expects($this->once())
            ->method('count')
            ->with('hello')
            ->willReturn(4);

        $cache = new CharCounterCache($counterMock, $storageMock);

        $result = $cache->count('hello');

        $this->assertSame(4, $result);
    }

}
