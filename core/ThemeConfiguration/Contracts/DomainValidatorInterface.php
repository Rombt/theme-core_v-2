<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Contracts;

use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;

interface DomainValidatorInterface
{
    public function validate(ConfigurationDomain $domain): void;
}
