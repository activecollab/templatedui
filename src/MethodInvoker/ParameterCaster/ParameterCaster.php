<?php

/*
 * This file is part of the Slingshot project.
 *
 * (c) PhpCloud.org Core Team <core@phpcloud.org>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\MethodInvoker\ParameterCaster;

use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

class ParameterCaster implements ParameterCasterInterface
{
    private ReflectionParameter $parameter;

    public function __construct(ReflectionParameter $parameter)
    {
        $this->parameter = $parameter;
    }

    public function hasDefaultValue(): bool
    {
        return $this->parameter->isDefaultValueAvailable();
    }

    public function getDefaultValue(): mixed
    {
        return $this->parameter->getDefaultValue();
    }

    public function castToType($inputValue)
    {
        if ($this->parameter->getType() instanceof ReflectionUnionType) {
            return $inputValue;
        }

        return match ($this->parameter->getType()->getName()) {
            'string' => (string)$inputValue,
            'int' => (int)$inputValue,
            'float' => is_int($inputValue) ? $inputValue : (float)$inputValue,
            'bool' => (bool)$inputValue,
            'array' => (array)$inputValue,
            default => $inputValue,
        };
    }

    public function checkLooseCasting(): bool
    {
        if ($this->parameter->getType() instanceof ReflectionUnionType) {
            return false;
        }

        return in_array(
            $this->parameter->getType()->getName(),
            [
                'int',
                'string',
                'float',
                'bool',
            ]
        );
    }
}
