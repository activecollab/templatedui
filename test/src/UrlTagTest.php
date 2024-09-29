<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Test;

use ActiveCollab\TemplatedUI\Base\UrlTag;
use ActiveCollab\TemplatedUI\Integrate\PathsResolverInterface;
use ActiveCollab\TemplatedUI\Integrate\UrlAssemblerInterface;
use ActiveCollab\TemplatedUI\Test\Base\TestCase;

class UrlTagTest extends TestCase
{
    public function testWillCleanUpRootUrl(): void
    {
        $pathsResolver = $this->createMock(PathsResolverInterface::class);
        $pathsResolver
            ->expects($this->once())
            ->method('getRootUrl')
            ->willReturn('https://example.com/');

        $urlAssembler = $this->createMock(UrlAssemblerInterface::class);
        $urlAssembler
            ->expects($this->once())
            ->method('pathFor')
            ->with('routeName', [])
            ->willReturn('path');

        $this->assertSame(
            'https://example.com/path',
            (new UrlTag(
                $pathsResolver,
                $urlAssembler,
            ))->render('routeName'),
        );
    }

    public function testWillCleanUpPath(): void
    {
        $pathsResolver = $this->createMock(PathsResolverInterface::class);
        $pathsResolver
            ->expects($this->once())
            ->method('getRootUrl')
            ->willReturn('https://example.com/');

        $urlAssembler = $this->createMock(UrlAssemblerInterface::class);
        $urlAssembler
            ->expects($this->once())
            ->method('pathFor')
            ->with('routeName', [])
            ->willReturn('/path');

        $this->assertSame(
            'https://example.com/path',
            (new UrlTag(
                $pathsResolver,
                $urlAssembler,
            ))->render('routeName'),
        );
    }
}
