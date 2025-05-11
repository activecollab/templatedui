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

class FormatNumberModifier extends Modifier
{
    public function modify(
        int|float $number,
        ?NumberFormatterInterface $numberFormatter = null,
        int $decimals = 2,
        bool $trimZeros = true,
        int $shortNotationAfter = 10000,
    ): string
    {
        if ($numberFormatter) {
            return $numberFormatter->formatNumber(
                $number,
                $decimals,
                $trimZeros,
                $shortNotationAfter,
            );
        }

        return number_format($number);
    }
}
