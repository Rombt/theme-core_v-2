<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

interface DomainValidatorInterface
{
    public function validate(
        ConfigurationDomainInterface $domain,
    ): void;
}
