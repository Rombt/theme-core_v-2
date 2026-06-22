<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

final readonly class ThemeConfigurationPackage
{
    public function __construct(
        private PackageId $id,
        private PackageMetadata $metadata,
        private DomainCollection $domains,
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

    public function domains(): DomainCollection
    {
        return $this->domains;
    }
}
