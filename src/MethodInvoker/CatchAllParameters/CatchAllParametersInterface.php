<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\MethodInvoker\CatchAllParameters;

interface CatchAllParametersInterface
{
    public function getParameters(): array;
    public function hasParameter(string $parameterName): bool;
    public function getParameter(string $parameterName, mixed $default = null): mixed;
    public function mustGetParameter(string $parameterName): mixed;
}
