<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\DateValue\DateTimeValueInterface;
use ActiveCollab\DateValue\DateValueInterface;
use ActiveCollab\User\UserInterface;

class FormatDateModifier extends DateTimeModifier
{
    public function modify(
        mixed $input,
        UserInterface $user = null,
        bool $includeTime = true,
        bool $includeSeconds = false,
    ): string
    {
        if ($input instanceof DateValueInterface) {
            return $input->format(
                $this->getFormat(
                    false,
                    false,
                )
            );
        }

        if ($input instanceof DateTimeValueInterface) {
            if (empty($user)) {
                return $input->format($this->getFormat($includeTime, $includeSeconds));
            }

            return (clone $input)->setTimezone($user->getTimezone())->format(
                $this->getFormat(
                    $includeTime,
                    $includeSeconds,
                )
            );
        }

        return 'Invalid date';
    }

    private function getFormat(
        bool $includeTime,
        bool $includeSeconds,
    ): string
    {
        if (empty($includeTime)) {
            return $this->getDateFormat();
        }

        return $this->getDateTimeFormat($includeSeconds);
    }
}
