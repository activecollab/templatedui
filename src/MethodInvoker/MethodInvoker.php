<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\MethodInvoker;

use LogicException;
use ActiveCollab\TemplatedUI\ExtensionInterface;
use ActiveCollab\TemplatedUI\MethodInvoker\CatchAllParameters\CatchAllParameters;
use ActiveCollab\TemplatedUI\MethodInvoker\ParameterCaster\ParameterCaster;
use ActiveCollab\TemplatedUI\MethodInvoker\ParameterCaster\ParameterCasterInterface;
use ReflectionClass;
use RuntimeException;

class MethodInvoker implements MethodInvokerInterfaca
{
    private ExtensionInterface $invocationContext;

    public function __construct(ExtensionInterface $invocationContext)
    {
        $this->invocationContext = $invocationContext;
    }

    private array $parameterMaps = [];

    /**
     * @return ParameterCasterInterface[]
     */
    private function getMethodParametersMap(string $methodName): array
    {
        if (!array_key_exists($methodName, $this->parameterMaps)) {
            $this->parameterMaps[$methodName] = [];

            $reflection = new ReflectionClass($this->invocationContext);

            if (!$reflection->hasMethod($methodName)) {
                throw new LogicException(sprintf('Method %s not found in class %s.', $methodName, get_class($this)));
            }

            $method = $reflection->getMethod($methodName);

            foreach ($method->getParameters() as $methodParameter) {
                $this->parameterMaps[$methodName][$methodParameter->getName()] = new ParameterCaster($methodParameter);
            }
        }

        return $this->parameterMaps[$methodName];
    }

    public function invokeMethod(string $method, array $params = [])
    {
        $parametersMap = $this->getMethodParametersMap($method);

        $callFuncParams = [];
        $missingRequiredParameters = [];

        $catchAllParamIndex = null;

        foreach ($parametersMap as $parameterName => $parameter) {
            if ($this->isCatchAllParameter($parameterName)) {
                $callFuncParams[] = null;
                $catchAllParamIndex = count($callFuncParams) - 1;
                continue;
            }

            if (array_key_exists($parameterName, $params)) {
                $castedValue = $parameter->castToType($params[$parameterName]);

                if ($parameter->checkLooseCasting() && $castedValue != $params[$parameterName]) {
                    throw new RuntimeException(
                        sprintf(
                            'Casted value %s (%s) does no loosely match value after casting: %s (%s)',
                            var_export($castedValue, true),
                            gettype($castedValue),
                            var_export($params[$parameterName], true),
                            gettype($params[$parameterName]),
                        )
                    );
                }

                $callFuncParams[] = $castedValue;

                unset($params[$parameterName]);
            } elseif ($parameter->hasDefaultValue()) {
                $callFuncParams[] = $parameter->getDefaultValue();
            } else {
                $missingRequiredParameters[] = $parameterName;
            }
        }

        if (!empty($missingRequiredParameters)) {
            throw new LogicException(
                sprintf(
                    'Required arguments not found in %s call: %s.',
                    $this->invocationContext->getExtensionName(),
                    implode(', ', $missingRequiredParameters),
                )
            );
        }

        if ($catchAllParamIndex !== null) {
            $callFuncParams[$catchAllParamIndex] = new CatchAllParameters($params);
        }

        return call_user_func_array(
            [
                $this->invocationContext,
                $method,
            ],
            $callFuncParams
        );
    }

    private function isCatchAllParameter(string $parameterName): bool
    {
        return $parameterName === 'catchAllParameters';
    }
}
