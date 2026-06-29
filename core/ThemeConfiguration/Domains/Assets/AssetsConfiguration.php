<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Assets;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\IrExportableInterface;

final readonly class AssetsConfiguration implements
    ConfigurationDomainInterface,
    IrExportableInterface
{
    public function __construct(
        private array $assets,
    ) {
    }

    public function assets(): array
    {
        return $this->assets;
    }

    public function toArray(): array
    {
        return $this->assets;
    }
}
