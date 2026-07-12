<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Templates;

use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainValidatorInterface;

final readonly class TemplatesValidator implements DomainValidatorInterface
{
    public function validate(ConfigurationDomain $domain): void
    {
        // TODO: validation will be implemented later
    }
}
