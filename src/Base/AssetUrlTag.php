<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\TemplatedUI\Integrate\PathsResolverInterface;
use ActiveCollab\TemplatedUI\Tag\Tag;

class AssetTag extends Tag
{
    public function __construct(
        private PathsResolverInterface $pathsResolver,
    )
    {
    }

    public function render(string $assetPath): string
    {
        return sprintf(
            '%s/%s?%d',
            $this->pathsResolver->getAssetsUrl(),
            $assetPath,
            $this->pathsResolver->getAssetTimestamp($assetPath) ?? time(),
        );
    }
}
