<?php

/*
 * This file is part of the ActiveCollab TemplatedUI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Test;

use ActiveCollab\TemplatedUI\Base\FormatPercentModifier;
use ActiveCollab\TemplatedUI\Integrate\NumberFormatterInterface;
use ActiveCollab\TemplatedUI\Test\Base\TestCase;

class FormatPercentModifierTest extends TestCase
{
    /**
     * @dataProvider provideValuesForTest
     */
    public function testWillFormatPercent(
        int $inputValue,
        string $expectedValue,
    ): void
    {
        $this->assertSame(
            $expectedValue,
            (new FormatPercentModifier())->modify($inputValue),
        );
    }

    public function provideValuesForTest(): array
    {
        return [
            [99, '99%'],
        ];
    }

    public function testWillUseNumberFormatter(): void
    {
        $this->assertSame(
            '1,000%',
            (new FormatPercentModifier())->modify(
                1000,
                new class implements NumberFormatterInterface
                {
                    public function formatInt(int $number): string
                    {
                        return number_format($number, 0, '.', ',');
                    }
                }
            ),
        );
    }
}
