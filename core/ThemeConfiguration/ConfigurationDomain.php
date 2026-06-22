<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;

final readonly class ConfigurationDomain
{
    public function __construct(
        private DomainId $id,
        private ConfigurationDomainInterface $configuration,
    ) {
    }

    public function id(): DomainId
    {
        return $this->id;
    }

    public function configuration(): ConfigurationDomainInterface
    {
        return $this->configuration;
    }
}
