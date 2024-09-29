<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Base;

use ActiveCollab\Json\JsonEncoderInterface;
use ActiveCollab\TemplatedUI\Modifier\Modifier;

class JsonModifier extends Modifier
{
    public function __construct(
        private JsonEncoderInterface $jsonEncoder,
    )
    {
    }

    public function modify(mixed $input): string
    {
        return $this->jsonEncoder->encode($input);
    }
}
