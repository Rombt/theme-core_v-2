<?php

declare(strict_types=1);

namespace Tests\Support\Builders;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\BootstrapperInterface;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\KernelContext;

final class TestBootstrapBuilder
{
    /**
     * @var class-string<BootstrapperInterface>[]
     */
    private array $bootstrappers = [];

    private ?BootstrapRegistry $registry = null;

    private ?BootstrapperFactory $factory = null;

    public static function create(): self
    {
        return new self();
    }

    /**
     * @param class-string<BootstrapperInterface> $bootstrapper
     */
    public function addBootstrapper(string $bootstrapper): self
    {
        $this->bootstrappers[] = $bootstrapper;
        return $this;
    }

    /**
     * @param class-string<BootstrapperInterface>[] $bootstrappers
     */
    public function withBootstrappers(array $bootstrappers): self
    {
        $this->bootstrappers = $bootstrappers;
        return $this;
    }

    public function withRegistry(BootstrapRegistry $registry): self
    {
        $this->registry = $registry;
        return $this;
    }

    public function withFactory(BootstrapperFactory $factory): self
    {
        $this->factory = $factory;
        return $this;
    }

    public function build(Application $app): Kernel
    {
        $registry = $this->registry ?? new BootstrapRegistry();

        foreach ($this->bootstrappers as $bootstrapper) {
            $registry->register($bootstrapper);
        }

        $factory = $this->factory ?? new BootstrapperFactory();

        return new Kernel(
            app: $app,
            bootstrapRegistry: $registry,
            bootstrapperFactory: $factory,
            context: new KernelContext($app),
            projectRoot: dirname(__DIR__, 3),
        );
    }
}
