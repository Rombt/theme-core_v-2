<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Queries;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\IrExportableInterface;

final readonly class QueriesConfiguration implements
    ConfigurationDomainInterface
{
    public function __construct(
        private array $queries,
    ) {
    }

    public function queries(): array
    {
        return $this->queries;
    }

    public function toArray(): array
    {
        return $this->queries;
    }
}
