<?php

/*
 * This file is part of the ActiveCollab Templated UI project.
 *
 * (c) A51 doo <info@activecollab.com>
 */

declare(strict_types=1);

namespace ActiveCollab\TemplatedUI\Integrate;

interface PathsResolverInterface
{
    /**
     * Return application's root URL.
     */
    public function getRootUrl(): string;

    /**
     * Return absolute path to the directory where templates are stored.
     */
    public function getTemplatesPath(): string;

    /**
     * Return absolute path to the directory where built assets are stored.
     *
     * If assets are not available locally, this method should return NULL.
     */
    public function getAssetsPath(): ?string;


    /**
     * Return absolute assets URL, without a trailing slash.
     */
    public function getAssetsUrl(): string;

    /**
     * Return modification timestamp of an asset, or NULL when asset is not available.
     */
    public function getAssetTimestamp(string $assetPath): ?int;
}
