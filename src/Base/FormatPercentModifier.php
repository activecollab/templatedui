<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\TemplatedUI\Integrate\NumberFormatterInterface;
use ActiveCollab\TemplatedUI\Modifier\Modifier;

class FormatPercentModifier extends Modifier
{
    public function modify(
        int|float $percent,
        ?NumberFormatterInterface $numberFormatter = null,
        bool $trimZeros = false,
    ): string
    {
        if ($numberFormatter) {
            return sprintf(
                '%s%%',
                $numberFormatter->formatNumber(
                    $percent,
                    trimZeros:  $trimZeros,
                ),
            );
        }

        return sprintf('%d%%', $percent);
    }
}
