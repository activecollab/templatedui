<?php

/*
 * This file is part of the ActiveCollab TemplatedUI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Test;

use ActiveCollab\TemplatedUI\Base\ExportModifier;
use ActiveCollab\TemplatedUI\Test\Base\TestCase;

class ExportModifierTest extends TestCase
{
    public function testWillExportVariable(): void
    {
        $this->assertSame(
            'false',
            (new ExportModifier())->modify(false),
        );
    }
}
