<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\OpenCloseBlock;

use LogicException;
use ActiveCollab\TemplatedUI\Block\Block;
use ActiveCollab\TemplatedUI\MethodInvoker\MethodInvoker;
use Smarty_Internal_Template;

class OpenCloseBlock extends Block implements OpenCloseBlockInterface
{
    public function __invoke(
        array $params,
        ?string $content,
        Smarty_Internal_Template $smarty,
        bool $repeat
    ): string
    {
        if (array_key_exists('content', $params))  {
            throw new LogicException('Parameters named content are not allowed in blocks.');
        }

        if ($repeat) {
            return (new MethodInvoker($this))->invokeMethod('open', $params);
        }

        return (new MethodInvoker($this))->invokeMethod('close',
            array_merge(
                $params,
                [
                    'content' => $content,
                ]
            )
        );
    }
}