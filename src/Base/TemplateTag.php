<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\TemplatedUI\Integrate\PathsResolverInterface;
use ActiveCollab\TemplatedUI\MethodInvoker\CatchAllParameters\CatchAllParametersInterface;
use ActiveCollab\TemplatedUI\Tag\Tag;

class TemplateTag extends Tag
{
    public function __construct(
        private PathsResolverInterface $pathsResolver,
    )
    {
    }

    public function render(
        string $sitemapPath,
        CatchAllParametersInterface $catchAllParameters,
    ): string
    {
        return $this->fetch(
            sprintf('%s/%s.tpl', $this->pathsResolver->getTemplatesPath(), $sitemapPath),
            $catchAllParameters->getParameters(),
        );
    }
}
