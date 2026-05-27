<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap;

use LogicException;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\BootstrapperInterface;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\SetInternalEncodingBootstrapper;

final class Kernel
{
    /**
     * @var array<class-string<BootstrapperInterface>>
     */
    private array $bootstrappers = [
        SetInternalEncodingBootstrapper::class,
    ];

    private bool $bootstrapped = false;

    public function __construct(
        private readonly Application $app,
    ) {
    }

    public function bootstrap(): void
    {
        if ($this->bootstrapped) {
            throw new LogicException(
                'Kernel has already been bootstrapped.'
            );
        }

        $executedBootstrappers = [];

        foreach ($this->bootstrappers as $bootstrapperClass) {
            $bootstrapper = new $bootstrapperClass();

            $bootstrapper->bootstrap($this->app);

            $executedBootstrappers[] = $bootstrapperClass;
        }

        $this->app->set(
            'kernel.bootstrappers.executed',
            $executedBootstrappers
        );

        $this->bootstrapped = true;
    }

    public function isBootstrapped(): bool
    {
        return $this->bootstrapped;
    }
}