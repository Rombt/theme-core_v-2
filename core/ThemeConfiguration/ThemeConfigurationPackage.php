<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

final readonly class ThemeConfigurationPackage
{
    public function __construct(
        private PackageId $id,
        private DomainCollection $domains,
        private array $configuration
    ) {
    }

    public function id(): PackageId
    {
        return $this->id;
    }

    public function domains(): DomainCollection
    {
        return $this->domains;
    }

    /**
     * @return array<string, mixed>
     */
    public function configuration(): array
    {
        return $this->configuration;
    }
}
