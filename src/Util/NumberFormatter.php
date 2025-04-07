<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Util;

class NumberFormatter
{
    public function __construct(
        private string $decimalSeparator = '.',
        private string $thousandSeparator = ',',
    )
    {
    }

    public function formatNumber(
        int|float $number,
        int $decimals = 2,
        bool $trimZeros = true,
        int $shortNotationAfter = 1000,
    ): string
    {
        if ($number === 0) {
            return '0';
        }

        [
            $numberToFormat,
            $suffix,
        ] = $this->getNumberToFormat(
            $number,
            $decimals,
            $shortNotationAfter,
        );

        $formattedNumber = number_format($numberToFormat, $decimals, $this->decimalSeparator, $this->thousandSeparator);

        if ($trimZeros) {
            $formattedNumber = $this->trimZeros($formattedNumber);
        }

        return sprintf('%s%s', $formattedNumber, $suffix);
    }

    private function getNumberToFormat(
        int|float $number,
        int $decimals,
        int $shortNotationAfter,
    ): array
    {
        if ($shortNotationAfter < 1 || $number < $shortNotationAfter) {
            return [
                $number,
                '',
            ];
        }

        if ($number >= 1000000000) {
            return [
                round($number / 1000000000, $decimals),
                'B',
            ];
        }

        if ($number >= 1000000) {
            return [
                round($number / 1000000, $decimals),
                'M',
            ];
        }

        if ($number >= 1000) {
            return [
                round($number / 1000, $decimals),
                'K',
            ];
        }

        return [
            $number,
            '',
        ];
    }

    private function trimZeros(string $formattedNumber): string
    {
        return rtrim(rtrim($formattedNumber, '0'), $this->decimalSeparator);
    }
}
