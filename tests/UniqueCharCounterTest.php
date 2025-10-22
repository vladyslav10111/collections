<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection\Tests;

use PHPUnit\Framework\TestCase;
use Vladyslav10111\Collection\CharCounterCache;
use Vladyslav10111\Collection\UniqueCharCounter;

require __DIR__ . '/../vendor/autoload.php';

class UniqueCharCounterTest extends TestCase
{
    public function testReturnsCachedValue(): void
    {
        $inputString = 'hello';
        $cachedValue = 4;

        $cache = $this->createMock(CharCounterCache::class);
        $cache->expects($this->once())
            ->method('get')
            ->with($inputString)
            ->willReturn($cachedValue);

        $cache->expects($this->never())
            ->method('set');

        $counter = $this->getMockBuilder(UniqueCharCounter::class)
            ->setConstructorArgs([$cache])
            ->onlyMethods(['calculateUniqueChars'])
            ->getMock();

        $counter->expects($this->never())
            ->method('calculateUniqueChars');

        $result = $counter->countUniqueChars($inputString);

        $this->assertEquals($cachedValue, $result);
    }
    public function testCalculatesAndCachesValueWhenNotInCache(): void
    {
        $inputString = 'hello';
        $calculatedValue = 4;

        $cache = $this->createMock(CharCounterCache::class);

        $cache->expects($this->once())
            ->method('get')
            ->with($inputString)
            ->willReturn(null);

        $cache->expects($this->once())
            ->method('set')
            ->with($inputString, $calculatedValue);

        $counter = $this->getMockBuilder(UniqueCharCounter::class)
            ->setConstructorArgs([$cache])
            ->onlyMethods(['calculateUniqueChars'])
            ->getMock();

        $counter->expects($this->once())
            ->method('calculateUniqueChars')
            ->with($inputString)
            ->willReturn($calculatedValue);

        $result = $counter->countUniqueChars($inputString);

        $this->assertEquals($calculatedValue, $result);
    }
    public function testReturnTypeIsInt(): void
    {
        $inputString = 'hello';
        $cachedValue = 4;

        $cache = $this->createMock(CharCounterCache::class);

        $cache->method('get')
            ->willReturn($cachedValue);

        $counter = new UniqueCharCounter($cache);

        $result = $counter->countUniqueChars($inputString);

        $this->assertIsInt($result);
    }
    public function testCalculateUniqueCharsActualLogic(): void
    {
        $inputString = 'hello';
        $cachedValue = 4;

        $cache = $this->createMock(CharCounterCache::class);
        $counter = new UniqueCharCounter($cache);

        $result = $counter->calculateUniqueChars($inputString);

        $this->assertEquals($cachedValue, $result);
    }
}
