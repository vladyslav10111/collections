<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Vladyslav10111\Collection\UniqueCharCounter;

class UniqueCharCounterTest extends TestCase
{
    public function testReturnTypeIsInt(): void
    {
        $inputString = 'hello';
        $counter = new UniqueCharCounter();

        $result = $counter->count($inputString);

        $this->assertIsInt($result);
    }

    public function testCalculateUniqueCharsActualLogic(): void
    {
        $inputString = 'hello';
        $expected = 3;

        $counter = new UniqueCharCounter();
        $result = $counter->count($inputString);

        $this->assertEquals($expected, $result);
    }

    #[DataProvider('stringProvider')]
    public function testCountUniqueCharsWithVariousInputs(string $input, int $expected): void
    {
        $counter = new UniqueCharCounter();
        $this->assertEquals($expected, $counter->count($input));
    }

    public static function stringProvider(): array
    {
        return [
            ['abbbccdf', 3],
            ['hello', 3],
            ['abc', 3],
            ['aabbcc', 0],
            ['aab', 1],
            ['a', 1],
            ['', 0],
        ];
    }
}