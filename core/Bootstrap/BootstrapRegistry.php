<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap;

use Rombt\ThemeCore\Bootstrap\Bootstrappers\BootstrapperInterface;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetInternalEncodingBootstrapper;

final class BootstrapRegistry
{
    /**
     * @var array<class-string<BootstrapperInterface>>
     */
    private array $bootstrappers = [
        SetInternalEncodingBootstrapper::class,
    ];

    /**
     * @return array<class-string<BootstrapperInterface>>
     */
    public function all(): array
    {
        return $this->bootstrappers;
    }
}