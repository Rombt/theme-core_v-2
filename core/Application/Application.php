<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Application;

use RuntimeException;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextInterface;

final class Application
{
    private ?ApplicationContextInterface $context = null;

    public function setContext(
        ApplicationContextInterface $context
    ): void {
        if ($this->context !== null) {
            throw new RuntimeException(
                'ApplicationContext is already initialized.'
            );
        }

        $this->context = $context;
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
}
