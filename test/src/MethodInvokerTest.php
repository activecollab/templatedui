<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Test;

use ActiveCollab\DateValue\DateTimeValue;
use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\TemplatedUI\Test\Base\TestCase;
use LogicException;
use ActiveCollab\TemplatedUI\MethodInvoker\CatchAllParameters\CatchAllParametersInterface;
use ActiveCollab\TemplatedUI\MethodInvoker\MethodInvoker;
use ActiveCollab\TemplatedUI\Tag\Tag;
use RuntimeException;
use Stringable;

class MethodInvokerTest extends TestCase
{
    public function testWillThrowExceptionOnMissingMethod(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Method unknownMethod not found in class');

        $tag = new class() extends Tag {
        };

        $invoker = new MethodInvoker($tag);
        $invoker->invokeMethod('unknownMethod');
    }

    public function testWillThrowExceptionOnMissingRequiredParameter(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Required arguments not found');
        $this->expectExceptionMessage(': number');

        $tag = new class() extends Tag {
            public function getExtensionName(): string
            {
                return 'example';
            }

            public function render(int $number): string
            {
                return sprintf('Number is %d', $number);
            }
        };

        (new MethodInvoker($tag))->invokeMethod('render');
    }

    /**
     * @dataProvider provideDataForCastingTest
     */
    public function testWillCastScalars($valueToCast): void
    {
        $tag = new class() extends Tag {
            public function render(int $number): string
            {
                return sprintf('Number is %d', $number);
            }
        };

        $invoker = new MethodInvoker($tag);
        $this->assertSame(
            'Number is 15',
            $invoker->invokeMethod('render', ['number' => $valueToCast])
        );
    }

    public function provideDataForCastingTest(): array
    {
        return [
            [15],
            ['15'],
            ['15.0'],
        ];
    }

    public function testWillCheckCastedValues(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Casted value 15 (integer) does no loosely match value after casting');

        $tag = new class() extends Tag {
            public function render(int $number): string
            {
                return sprintf('Number is %d', $number);
            }
        };

        $invoker = new MethodInvoker($tag);
        $invoker->invokeMethod('render', ['number' => '15.015']);
    }

    /**
     * @dataProvider produceDataForArrayAutoConversionTest
     */
    public function testWillAutoConvertToSingleItemArraysWhenNeeded(
        $inputValue,
        string $expectedOutput
    ): void
    {
        $tag = new class() extends Tag {
            public function render(array $numbers): string
            {
                return sprintf('Numbers are: %s', implode(', ', $numbers));
            }
        };

        $invoker = new MethodInvoker($tag);
        $this->assertSame(
            $expectedOutput,
            $invoker->invokeMethod('render', ['numbers' => $inputValue])
        );
    }

    public function produceDataForArrayAutoConversionTest(): array
    {
        return [
            ['15', 'Numbers are: 15'],
            [[15, 25], 'Numbers are: 15, 25'],
        ];
    }

    public function testWillNotModifyObjects(): void
    {
        $tag = new class() extends Tag {
            public function render(DateTimeValueInterface $date): string
            {
                return $date->format('Y-m-d');
            }
        };

        $invoker = new MethodInvoker($tag);
        $this->assertSame(
            date('Y-m-d', (new DateTimeValue())->getTimestamp()),
            $invoker->invokeMethod(
                'render',
                [
                    'date' => new DateTimeValue(),
                ]
            )
        );
    }

    public function testWillNotCastUnionParameters(): void
    {
        $tag = new class() extends Tag {
            public function render(Stringable|string $value): Stringable|string
            {
                return $value;
            }
        };

        $invoker = new MethodInvoker($tag);
        $this->assertSame(
            'Scalar string',
            $invoker->invokeMethod(
                'render',
                [
                    'value' => 'Scalar string',
                ],
            ),
        );

        $this->assertSame(
            'Stringable object',
            (string) $invoker->invokeMethod(
                'render',
                [
                    'value' => new class implements Stringable{
                        public function __toString(): string
                        {
                            return 'Stringable object';
                        }
                    },
                ],
            ),
        );
    }

    public function testWillCatchAllParameters(): void
    {
        $tag = new class() extends Tag {
            public function render(int $number, CatchAllParametersInterface $catchAllParameters): string
            {
                return sprintf(
                    'Number is %d and there are %d more parameters',
                    $number,
                    count($catchAllParameters->getParameters())
                );
            }
        };

        $invoker = new MethodInvoker($tag);
        $this->assertSame(
            'Number is 15 and there are 3 more parameters',
            $invoker->invokeMethod(
                'render',
                [
                    'number' => 15,
                    'first' => '1',
                    'second' => '1',
                    'third' => '1',
                ]
            )
        );
    }
}
