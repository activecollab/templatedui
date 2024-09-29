<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Test;

use ActiveCollab\CurrentTimestamp\CurrentTimestampInterface;
use ActiveCollab\TemplatedUI\Base\AssetUrlTag;
use ActiveCollab\TemplatedUI\Integrate\PathsResolverInterface;
use ActiveCollab\TemplatedUI\Test\Base\TestCase;

class AssetUrlTagTest extends TestCase
{
    public function testWillUseAssetModificationTimeWhenAvailable(): void
    {
        $pathsResolver = $this->createMock(PathsResolverInterface::class);
        $pathsResolver
            ->expects($this->once())
            ->method('getAssetsUrl')
            ->willReturn('https://example.com/assets');
        $pathsResolver
            ->expects($this->once())
            ->method('getAssetTimestamp')
            ->willReturn(9876543210);

        $currentTimestamp = $this->createMock(CurrentTimestampInterface::class);
        $currentTimestamp
            ->expects($this->never())
            ->method('getCurrentTimestamp');

        $this->assertSame(
            'https://example.com/assets/css/style.css?9876543210',
            (new AssetUrlTag(
                $pathsResolver,
                $currentTimestamp,
            ))->render('css/style.css'),
        );
    }

    public function testWillUseCurrentTimestamp(): void
    {
        $pathsResolver = $this->createMock(PathsResolverInterface::class);
        $pathsResolver
            ->expects($this->once())
            ->method('getAssetsUrl')
            ->willReturn('https://example.com/assets');
        $pathsResolver
            ->expects($this->once())
            ->method('getAssetTimestamp')
            ->willReturn(null);

        $currentTimestamp = $this->createMock(CurrentTimestampInterface::class);
        $currentTimestamp
            ->expects($this->once())
            ->method('getCurrentTimestamp')
            ->willReturn(1234567890);

        $this->assertSame(
            'https://example.com/assets/css/style.css?1234567890',
            (new AssetUrlTag(
                $pathsResolver,
                $currentTimestamp,
            ))->render('css/style.css'),
        );
    }
}
