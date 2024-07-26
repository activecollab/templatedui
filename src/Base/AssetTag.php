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

class AssetTag extends Tag
{
    public function __construct(
        private RootUrlResolverInterface $rootUrlResolver,
    )
    {
    }

    public function render(string $assetPath): string
    {
        return sprintf(
            '%s/assets/%s',
            $this->rootUrlResolver->getUrl(),
            $assetPath,
        );
    }
}
