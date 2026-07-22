<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes;

use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainValidatorInterface;

final readonly class NodesValidator implements DomainValidatorInterface
{
    public function validate(ConfigurationDomain $domain): void
    {
        // TODO:
        // - validate required fields;
        // - validate node type;
        // - validate processing strategy;
        // - validate resource references using ResourceResolver.
    }
}
