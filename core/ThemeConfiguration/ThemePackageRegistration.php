<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageLoaderInterface;

final readonly class ThemePackageRegistration
{
    public function __construct(
        private PackageId $id,
        private PackageMetadata $metadata,
        private PackageLoaderInterface $loader,
    ) {
    }

    public function id(): PackageId
    {
        return $this->id;
    }

    public function metadata(): PackageMetadata
    {
        return $this->metadata;
    }

    public function loader(): PackageLoaderInterface
    {
        return $this->loader;
    }
}
