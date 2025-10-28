<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection\Tests;

use PHPUnit\Framework\TestCase;
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

    /**
     * @dataProvider stringProvider
     */
    public function testCountUniqueCharsWithVariousInputs(string $input, int $expected): void
    {
        $counter = new UniqueCharCounter();
        $result = $counter->count($input);

        $this->assertEquals($expected, $result);
    }

    public static function stringProvider(): array
    {
        return [
            ['abbbccdf', 3],
        ];
    }
}
