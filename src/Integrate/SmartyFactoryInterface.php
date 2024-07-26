<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Integrate;

use ActiveCollab\TemplateEngine\TemplateEngineInterface;
use ActiveCollab\TemplatedUI\ExtensionInterface;
use Smarty;

interface SmartyFactoryInterface
{
    public function createSmarty(): Smarty;
    public function createTemplateEngine(): TemplateEngineInterface;
    public function hasExtension(string $extensionType): bool;

    /**
     * @template TClassName
     * @param  class-string<TClassName> $extensionType
     * @return TClassName|ExtensionInterface
     */
    public function getExtension(string $extensionType): ?ExtensionInterface;
}
