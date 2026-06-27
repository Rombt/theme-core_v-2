<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Templates;

use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainValidatorInterface;

final readonly class TemplatesValidator implements DomainValidatorInterface
{
    public function validate(ConfigurationDomain $domain): void
    {
        // Пока ничего не проверяем.
    }
}
