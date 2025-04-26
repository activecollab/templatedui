<?php

/*
 * This file is part of the Slingshot project.
 *
 * (c) PhpCloud.org Core Team <core@phpcloud.org>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI;

use ActiveCollab\TemplatedUI\MethodInvoker\InvocableMethodContextInterface;

interface ExtensionInterface extends InvocableMethodContextInterface
{
    public function getExtensionName(): string;
}
