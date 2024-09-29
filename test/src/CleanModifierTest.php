<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Test;

use ActiveCollab\TemplatedUI\Base\CleanModifier;
use ActiveCollab\TemplatedUI\Test\Base\TestCase;

class CleanModifierTest extends TestCase
{
    public function testWillCleanHtml(): void
    {
        $this->assertSame(
            '&lt;a href=&quot;https://example.com&quot;&gt;Link to Example&lt;/a&gt;',
            (new CleanModifier())->modify('<a href="https://example.com">Link to Example</a>'),
        );
    }
}
