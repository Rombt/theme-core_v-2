<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\IrExportableInterface;

final readonly class CompositionsConfiguration implements
    ConfigurationDomainInterface
{
    public function __construct(
        private array $compositions,
    ) {
    }

    public function compositions(): array
    {
        return $this->compositions;
    }
}
