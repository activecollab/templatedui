<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\User\UserInterface;

class FormatTimeModifier extends DateTimeModifier
{
    public function modify(
        mixed $input,
        UserInterface $user = null,
        bool $includeSeconds = false,
    ): string
    {
        if ($input instanceof DateTimeValueInterface) {
            if (empty($user)) {
                return $input->format($this->getTimeFormat($includeSeconds));
            }

            return (clone $input)->setTimezone($user->getTimezone())->format($this->getTimeFormat($includeSeconds));
        }

        return 'Invalid date time';
    }
}
