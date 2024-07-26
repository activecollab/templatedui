<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Tag;

use ActiveCollab\TemplatedUI\Extension;
use ActiveCollab\TemplatedUI\MethodInvoker\MethodInvoker;
use Smarty_Internal_Template;

abstract class Tag extends Extension implements TagInterface
{
    public function __invoke(
        array $params,
        Smarty_Internal_Template $smarty,
    ): string
    {
        return (new MethodInvoker($this))->invokeMethod('render', $params);
    }

    protected function getExtensionTypeSuffix(): string
    {
        return 'Tag';
    }
}
