<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap;

use Rombt\ThemeCore\Bootstrap\Bootstrappers\BootstrapperInterface;

final class BootstrapRegistry
{
    /**
     * @var array<class-string<BootstrapperInterface>>
     */
    private array $bootstrappers = [];

    /**
     * @param class-string<BootstrapperInterface> $bootstrapper
     */
    public function register(string $bootstrapper): void
    {
        $this->bootstrappers[] = $bootstrapper;
    }

    /**
     * @return array<class-string<BootstrapperInterface>>
     */
    public function all(): array
    {
        return $this->bootstrappers;
    }
}