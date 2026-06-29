<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Queries;

use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainValidatorInterface;

final readonly class QueriesValidator implements DomainValidatorInterface
{
    public function validate(ConfigurationDomain $domain): void
    {
        // TODO: validation will be implemented later
    }
}
