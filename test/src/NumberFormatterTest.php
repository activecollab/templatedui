<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Test;

use ActiveCollab\TemplatedUI\Test\Base\TestCase;
use ActiveCollab\TemplatedUI\Util\NumberFormatter;

class NumberFormatterTest extends TestCase
{
    /**
     * @dataProvider provideNumbersToFormat
     */
    public function testDefaultNumberFormatter(
        int|float $number,
        string $expectedFormatterNumber,
    ): void
    {
        $this->assertSame(
            $expectedFormatterNumber,
            (new NumberFormatter())->formatNumber($number),
        );
    }

    public function provideNumbersToFormat(): array
    {
        return [
            [0, '0'],
            [0.0, '0'],
            [1.33333, '1.33'],
            [999, '999'],
            [1001, '1K'],
            [1499, '1.5K'],
            [1000001, '1M'],
            [1513439, '1.51M'],
            [1000000000, '1B'],
            [2089000123, '2.09B'],
        ];
    }
}
