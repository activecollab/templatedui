<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\TemplatedUI\Modifier\Modifier;

abstract class DateTimeModifier extends Modifier
{
    protected function getDateTimeFormat(bool $includeSeconds): string
    {
        return sprintf(
            '%s %s',
            $this->getDateFormat(),
            $this->getTimeFormat($includeSeconds),
        );
    }

    protected function getDateFormat(): string
    {
        return 'Y-m-d';
    }

    protected function getTimeFormat(bool $includeSeconds): string
    {
        return $includeSeconds ? 'G:i:s' : 'G:i';
    }
}
