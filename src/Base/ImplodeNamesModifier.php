<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\TemplatedUI\Modifier\Modifier;

class ImplodeNamesModifier extends Modifier
{
    public function modify(array $values): string
    {
        $values = array_values($values);
        $valuesCount = count($values);

        return match ($valuesCount) {
            0 => '',
            1 => $this->getNameFromValue($values[0]),
            2 => sprintf(
                '%s, and %s',
                $this->getNameFromValue($values[0]),
                $this->getNameFromValue($values[1]),
            ),
            default => sprintf(
            '%s, and %s',
                implode(
                    ', ',
                    array_map(
                        fn ($value) => $this->getNameFromValue($value),
                        array_slice(
                            $values,
                            0,
                            $valuesCount - 1,
                        )
                    )
                ),
                $this->getNameFromValue($values[$valuesCount - 1])
            ),
        };
    }

    private function getNameFromValue(mixed $value): string
    {
        return (string) $value;
    }
}
