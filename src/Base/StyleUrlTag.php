<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\CurrentTimestamp\CurrentTimestampInterface;
use ActiveCollab\TemplatedUI\Integrate\PathsResolverInterface;
use ActiveCollab\TemplatedUI\Tag\Tag;

class StyleUrlTag extends Tag
{
    public function __construct(
        private PathsResolverInterface $pathsResolver,
        private CurrentTimestampInterface $currentTimestamp,
    )
    {
    }

    public function render(string $styleName = 'main.css'): string
    {
        return sprintf(
            '%s/%s?%d',
            $this->pathsResolver->getAssetsUrl(),
            $styleName,
            $this->pathsResolver->getAssetTimestamp($styleName) ?? $this->currentTimestamp->getCurrentTimestamp(),
        );
    }
}
