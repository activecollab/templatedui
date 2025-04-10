<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI;

use ActiveCollab\ContainerAccess\ContainerAccessInterface;
use ActiveCollab\ContainerAccess\ContainerAccessInterface\Implementation as ContainerAccessImplementation;
use ActiveCollab\TemplatedUI\Helper\HtmlHelpersTrait;
use ActiveCollab\TemplatedUI\Integrate\SmartyFactoryInterface;
use ActiveCollab\TemplateEngine\TemplateEngineInterface;
use RuntimeException;
use simple_html_dom;

abstract class Extension implements ExtensionInterface, ContainerAccessInterface
{
    use ContainerAccessImplementation;
    use HtmlHelpersTrait;

    private ?string $extensionName = null;

    public function getExtensionName(): string
    {
        if ($this->extensionName === null) {
            $bits = explode('\\', get_class($this));
            $lastBit = $bits[count($bits) - 1];

            $extensionTypeSuffixLength = mb_strlen($this->getExtensionTypeSuffix());

            if (mb_substr($lastBit, -1 * $extensionTypeSuffixLength) === $this->getExtensionTypeSuffix()) {
                $lastBit = mb_substr($lastBit, 0, mb_strlen($lastBit) - $extensionTypeSuffixLength);
            }

            $this->extensionName = $lastBit;
        }

        return $this->extensionName;
    }

    protected function htmlToDom(string $html): simple_html_dom
    {
        $dom = new simple_html_dom(
            null,
            true,
            true,
            'UTF-8',
            "\r\n",
        );
        $dom->load($html, true, true);

        return $dom;
    }

    protected function fetch(string $templatePath, array $data = []): string
    {
        return $this->getContainer()
            ->get(TemplateEngineInterface::class)
                ->fetch($templatePath, $data);
    }

    /**
     * @template TClassName
     * @param  class-string<TClassName> $id
     * @return TClassName
     */
    protected function get(string $id): mixed
    {
        return $this->getContainer()->get($id);
    }

    /**
     * @template TClassName
     * @param  class-string<TClassName> $extensionType
     * @return TClassName
     */
    protected function getExtension(string $extensionType): ?ExtensionInterface
    {
        return $this->get(SmartyFactoryInterface::class)->getExtension($extensionType);
    }

    /**
     * @template TClassName
     * @param  class-string<TClassName> $extensionType
     * @return TClassName
     */
    protected function mustGetExtension(string $extensionType): ExtensionInterface
    {
        $extension = $this->getExtension($extensionType);

        if (empty($extension)) {
            throw new RuntimeException(sprintf('Extension "%s" not found.', $extensionType));
        }

        return $extension;
    }

    abstract protected function getExtensionTypeSuffix(): string;
}
