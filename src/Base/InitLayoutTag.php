<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\TemplatedUI\Tag\Tag;

class InitLayoutTag extends Tag
{
    public function render(string $layoutFileName): string
    {
        return '<script>' .
            sprintf('document.body.className = "%s_layout";', $this->getLayoutName($layoutFileName)) .
        '</script>';
    }

    private function getLayoutName(string $layoutFileName): string
    {
        return explode('.', $layoutFileName)[0];
    }
}
