<?php

/*
 * This file is part of the Slingshot project.
 *
 * (c) PhpCloud.org Core Team <core@phpcloud.org>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\MethodInvoker;

interface MethodInvokerInterfaca
{
    public function invokeMethod(string $method, array $params = []);
}
