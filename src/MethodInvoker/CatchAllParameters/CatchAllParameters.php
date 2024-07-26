<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\MethodInvoker\CatchAllParameters;

use InvalidArgumentException;

class CatchAllParameters implements CatchAllParametersInterface
{
    public function __construct(
        private array $arguments
    )
    {
    }

    public function getParameters(): array
    {
        return $this->arguments;
    }

    public function hasParameter(string $parameterName): bool
    {
        return array_key_exists($parameterName, $this->arguments);
    }

    public function getParameter(string $parameterName, mixed $default = null): mixed
    {
        if ($this->hasParameter($parameterName)) {
            return $this->arguments[$parameterName];
        }

        return $default;
    }

    public function mustGetParameter(string $parameterName): mixed
    {
        if (!array_key_exists($parameterName, $this->arguments)) {
            throw new InvalidArgumentException(sprintf('Argument %s not found.', $parameterName));
        }

        return $this->arguments[$parameterName];
    }
}
