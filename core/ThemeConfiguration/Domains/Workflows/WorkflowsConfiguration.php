<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Workflows;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\IrExportableInterface;

final readonly class WorkflowsConfiguration implements
    ConfigurationDomainInterface,
    IrExportableInterface
{
    public function __construct(
        private array $workflows,
    ) {
    }

    public function workflows(): array
    {
        return $this->workflows;
    }

    public function toArray(): array
    {
        return $this->workflows;
    }
}
