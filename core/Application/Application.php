<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Application;

use RuntimeException;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextBuilderInterface;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextInterface;

final class Application
{
    private ?ApplicationContextBuilderInterface $contextBuilder = null;

    private ?ApplicationContextInterface $context = null;

    public function setContextBuilder(ApplicationContextBuilderInterface $builder): void
    {
        if ($this->contextBuilder !== null) {
            throw new RuntimeException(
                'ApplicationContextBuilder is already initialized.'
            );
        }

        if ($this->context !== null) {
            throw new RuntimeException(
                'ApplicationContext already exists.'
            );
        }

        $this->contextBuilder = $builder;
    }

    public function getContextBuilder(): ApplicationContextBuilderInterface
    {
        if ($this->contextBuilder === null) {
            throw new RuntimeException(
                'ApplicationContextBuilder is not initialized.'
            );
        }

        return $this->contextBuilder;
    }

    public function setContext(ApplicationContextInterface $context): void
    {
        if ($this->context !== null) {
            throw new RuntimeException(
                'ApplicationContext is already initialized.'
            );
        }

        $this->context = $context;

        $this->contextBuilder = null;
    }

    public function getContext(): ApplicationContextInterface
    {
        if ($this->context === null) {
            throw new RuntimeException(
                'ApplicationContext is not initialized.'
            );
        }

        return $this->context;
    }

    public function hasContext(): bool
    {
        return $this->context !== null;
    }
}
