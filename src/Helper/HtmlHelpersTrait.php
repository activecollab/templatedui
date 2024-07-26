<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Helper;

trait HtmlHelpersTrait
{
    protected function openHtmlTag(
        string $name,
        array $attributes = null,
        string $content = null,
        bool $sanitizeContent = true
    ): string
    {
        if (!empty($attributes)) {
            $result = "<$name";

            foreach ($attributes as $k => $v) {
                if ($k) {
                    if (is_bool($v)) {
                        if ($v) {
                            $result .= " $k";
                        }
                    } else {
                        $result .= ' ' . $k . '="' . ($v ? $this->sanitizeForHtml($v) : $v) . '"';
                    }
                }
            }

            $result .= '>';
        } else {
            $result = "<$name>";
        }

        if ($content) {
            $result .= ($sanitizeContent ? $this->sanitizeForHtml($content) : $content) . "</$name>";
        }

        return $result;
    }

    protected function closeHtmlTag(string $name): string
    {
        return sprintf('</%s>', $name);
    }

    protected function prepareClassAttribute(string $userProvidedClass, string ...$classes): string
    {
        return trim(
            implode(
                ' ',
                array_unique(
                    array_merge(
                        explode(' ', $userProvidedClass),
                        $classes
                    )
                )
            )
        );
    }

    protected function sanitizeForHtml(mixed $input): string
    {
        if ($input === null) {
            return '';
        }

        if (is_object($input) && method_exists($input, '__toString')) {
            return $this->sanitizeForHtml($input->__toString());
        }

        if (is_scalar($input)) {
            return str_replace(
                [
                    '<',
                    '>',
                    '"',
                ],
                [
                    '&lt;',
                    '&gt;',
                    '&quot;',
                ],
                preg_replace('/&(?!#(?:[0-9]+|x[0-9A-F]+);?)/si', '&amp;', (string) $input)
            );
        }

        $result = gettype($input);

        if (is_object($input)) {
            $result .= ' (' . get_class($input) . ')';
        }

        return $result;
    }
}
