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

class ScriptUrlTag extends Tag
{
    public function __construct(
        private PathsResolverInterface $pathsResolver,
        private CurrentTimestampInterface $currentTimestamp,
    )
    {
    }

    public function render(string $scriptName = 'application.js'): string
    {
        return sprintf(
            '%s/%s?%d',
            $this->pathsResolver->getAssetsUrl(),
            $scriptName,
            $this->pathsResolver->getAssetTimestamp($scriptName) ?? $this->currentTimestamp->getCurrentTimestamp(),
        );
    }
}
