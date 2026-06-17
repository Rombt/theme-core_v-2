<?php

declare(strict_types=1);

namespace Tests\Support\Builders;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\BootstrapRegistry;
use Rombt\ThemeCore\Bootstrap\BootstrapperFactory;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Bootstrap\KernelContext;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextBuilderInterface;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Tests\Support\Fakes\FakeApplicationContextBuilder;
use Tests\Support\Fakes\FakeLogger;
use Tests\Support\Fakes\FakeLogWriter;

final class TestApplicationBuilder
{
    private ?ApplicationContextBuilderInterface $contextBuilder = null;

    private ?FakeLogger $logger = null;

    private ?FakeLogWriter $writer = null;

    private ?BootstrapRegistry $bootstrapRegistry = null;

    private ?BootstrapperFactory $bootstrapperFactory = null;

    public static function create(): self
    {
        return new self();
    }

    public function withContextBuilder(
        ApplicationContextBuilderInterface $builder
    ): self {
        $this->contextBuilder = $builder;
        return $this;
    }

    public function withLogger(FakeLogger $logger): self
    {
        $this->logger = $logger;
        return $this;
    }

    public function withLogWriter(FakeLogWriter $writer): self
    {
        $this->writer = $writer;
        return $this;
    }

    public function withBootstrapRegistry(BootstrapRegistry $registry): self
    {
        $this->bootstrapRegistry = $registry;
        return $this;
    }

    public function withBootstrapperFactory(BootstrapperFactory $factory): self
    {
        $this->bootstrapperFactory = $factory;
        return $this;
    }

    public function build(): Application
    {
        $contextBuilder = $this->contextBuilder
        ?? new FakeApplicationContextBuilder();

        $logger = $this->logger ?? new FakeLogger();
        $writer = $this->writer ?? new FakeLogWriter();

        $contextBuilder->register(
            ApplicationContextKeys::LOGGER,
            $logger
        );

        $contextBuilder->register(
            ApplicationContextKeys::LOG_WRITER,
            $writer
        );

        $app = new Application();

        $app->setContextBuilder($contextBuilder);

        return $app;
    }
}
