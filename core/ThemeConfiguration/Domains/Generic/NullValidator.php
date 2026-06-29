<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Generic;

use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainValidatorInterface;

final readonly class NullValidator implements DomainValidatorInterface
{
    public function validate(
        ConfigurationDomain $domain,
    ): void {
        // Validation will be implemented later.
    }
}
