<?php

declare(strict_types=1);

namespace Vladyslav10111\Collection\Tests;

use PHPUnit\Framework\TestCase;
use Vladyslav10111\Collection\UniqueCharCounter;

require __DIR__ . '/../vendor/autoload.php';

class UniqueCharCounterTest extends TestCase
{

    public function testReturnTypeIsInt(): void
    {
        $inputString = 'hello';

        $counter = new UniqueCharCounter();

        $result = $counter->calculateUniqueChars($inputString);

        $this->assertIsInt($result);
    }
    public function testCalculateUniqueCharsActualLogic(): void
    {
        $inputString = 'hello';
        $cachedValue = 4;

        $counter = new UniqueCharCounter();

        $result = $counter->calculateUniqueChars($inputString);

        $this->assertEquals($cachedValue, $result);
    }
}
