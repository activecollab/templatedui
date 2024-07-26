<?php

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Integrate;

interface UrlAssemblerInterface
{
    public function pathFor(string $routeName, ?array $data = null): string;
}
