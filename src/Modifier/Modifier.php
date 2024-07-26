<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Modifier;

use ActiveCollab\TemplatedUI\Extension;

abstract class Modifier extends Extension implements ModifierInterface
{
    // First argument is value that needs to be modified.
    // Last argument is Smarty_Internal_Template.
    // Everything in between are extra arguments.
    public function __invoke(): string
    {
        if (method_exists($this, 'modify')) {
            return call_user_func_array([$this, 'modify'], func_get_args());
        }

        return '--not implemented--';
    }

    protected function getExtensionTypeSuffix(): string
    {
        return 'Modifier';
    }
}
