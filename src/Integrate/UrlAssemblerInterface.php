<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *ExportDataForMigration
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Integrate;

interface UrlAssemblerInterface
{
    public function pathFor(string $routeName, ?array $data = null): string;
}
