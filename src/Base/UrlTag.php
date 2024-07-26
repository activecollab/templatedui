<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\TemplatedUI\Integrate\RootUrlResolverInterface;
use ActiveCollab\TemplatedUI\Integrate\UrlAssemblerInterface;
use ActiveCollab\TemplatedUI\Tag\Tag;

class UrlTag extends Tag
{
    public function __construct(
        private RootUrlResolverInterface $rootUrlResolver,
        private UrlAssemblerInterface $urlAssembler,
    )
    {
    }

    public function render(
        string $routeName,
        ?array $data = null,
    ): string
    {
        return sprintf(
            '%s/%s',
            $this->rootUrlResolver->getUrl(),
            $this->urlAssembler->pathFor($routeName, $data ?? []),
        );
    }
}
