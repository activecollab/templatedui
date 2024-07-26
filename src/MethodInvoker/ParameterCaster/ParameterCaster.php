<?php

/*
 * This file is part of the Slingshot project.
 *
 * (c) PhpCloud.org Core Team <core@phpcloud.org>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\MethodInvoker\ParameterCaster;

use ReflectionParameter;

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
        switch ($this->parameter->getType()->getName()) {
            case 'string':
                return (string) $inputValue;
            case 'int':
                return (int) $inputValue;
            case 'float':
                return is_int($inputValue) ? $inputValue : (float) $inputValue;
            case 'bool':
                return (bool) $inputValue;
            case 'array':
                return (array) $inputValue;
            default:
                return $inputValue;
        }
    }

    public function checkLooseCasting(): bool
    {
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
