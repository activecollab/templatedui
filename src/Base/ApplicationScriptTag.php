<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\TemplatedUI\Integrate\RootUrlResolverInterface;
use ActiveCollab\TemplatedUI\Tag\Tag;

class ApplicationScriptTag extends Tag
{
    public function __construct(
        private RootUrlResolverInterface $rootUrlResolver,
    )
    {
    }

    public function render(string $scriptName = 'application.js'): string
    {
        return sprintf(
            '%s/assets/%s?%d',
            $this->rootUrlResolver->getUrl(),
            $scriptName,
            time(),
        );
    }
}
