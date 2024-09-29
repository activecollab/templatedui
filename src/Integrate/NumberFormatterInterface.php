<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Integrate;

interface NumberFormatterInterface
{
    public function formatInt(
        int $number,
    ): string;
}
