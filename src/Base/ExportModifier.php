<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\TemplatedUI\Modifier\Modifier;

class ExportModifier extends Modifier
{
    public function modify(mixed $input): string
    {
        return var_export($input, true);
    }
}
