<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Test\Unit;

use ActiveCollab\TemplatedUI\Base\ImplodeNamesModifier;
use ActiveCollab\TemplatedUI\Test\Base\TestCase;

class ImplodeNamesModifierTest extends TestCase
{
    /**
     * @dataProvider provideInputs
     */
    public function testWillModifyCorrectly(array $input, string $expectedOutput): void
    {
        $this->assertSame(
            $expectedOutput,
            (new ImplodeNamesModifier())->modify($input),
        );
    }

    public function provideInputs(): array
    {
        return [
            [[], ''],
            [['One element'], 'One element'],
            [['First', 'Second'], 'First, and Second'],
            [['First', 'Second', 'Third'], 'First, Second, and Third'],
            [['First', 'Second', 'Third', 'Fourth'], 'First, Second, Third, and Fourth'],
        ];
    }
}
