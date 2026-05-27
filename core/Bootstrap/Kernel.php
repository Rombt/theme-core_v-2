<?php

declare(strict_types=1);

namespace Core\Bootstrap;

namespace Rombt\ThemeCore\Bootstrap;

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

    public function __construct(
        private readonly Application $app,
    ) {
    }

    public function bootstrap(): void
    {
        foreach ($this->bootstrappers as $bootstrapperClass) {
            $bootstrapper = new $bootstrapperClass();

            $bootstrapper->bootstrap($this->app);
        }
    }
}