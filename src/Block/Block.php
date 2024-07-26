<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Block;

use ActiveCollab\TemplatedUI\Extension;

abstract class Block extends Extension implements BlockInterface
{
    protected function getExtensionTypeSuffix(): string
    {
        return 'Block';
    }
}
