<?php

/*
 * This file is part of the Slingshot project.
 *
 * (c) PhpCloud.org Core Team <core@phpcloud.org>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\MethodInvoker\ParameterCaster;

interface ParameterCasterInterface
{
    public function hasDefaultValue(): bool;
    public function getDefaultValue(): mixed;
    public function castToType($inputValue);
    public function checkLooseCasting(): bool;
}
