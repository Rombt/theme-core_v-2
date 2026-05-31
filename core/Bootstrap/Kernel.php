<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap;

use LogicException;
use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Bootstrappers\PrioritizedBootstrapperInterface;
use Rombt\ThemeCore\Bootstrap\KernelBootstrapStatus;

final class Kernel
{

    public function __construct(
        private readonly Application $app,
        private readonly BootstrapRegistry $bootstrapRegistry,
        private readonly BootstrapperFactory $bootstrapperFactory,
        private readonly KernelContext $context,
        private readonly string $projectRoot,
    ) {
    }

    public function projectRoot(): string
    {
        return $this->projectRoot;
    }

    public function bootstrap(): void
    {
        if ($this->isBootstrapped()) {
            throw new LogicException(
                'Kernel has already been bootstrapped.'
            );
        }

        $this->context->setStatus(
            KernelBootstrapStatus::BOOTSTRAPPING
        );

        $bootstrappers = $this->bootstrapRegistry->all();

        usort($bootstrappers, function (string $a, string $b): int {
            return $this->getPriority($b) <=> $this->getPriority($a);
        });

        $executedBootstrappers = [];

        try {
            foreach ($bootstrappers as $bootstrapperClass) {
                $this->context->setCurrent($bootstrapperClass);

                $bootstrapper = $this->bootstrapperFactory->create(
                    $bootstrapperClass
                );

                $bootstrapper->bootstrap($this->app,  $this);

                $executedBootstrappers[] = $bootstrapperClass;
            }
        } catch (Throwable $exception) {
            $this->context->setStatus( KernelBootstrapStatus::FAILED );
            $this->context->setFailed(true);
            $this->context->setCurrent(null);
            $this->context->setException($exception);

            throw $exception;
        }

        $this->context->setExecuted($executedBootstrappers);
        $this->context->setCurrent(null);

        $this->context->setStatus( KernelBootstrapStatus::BOOTSTRAPPED );
    }

    public function isBootstrapped(): bool
    {
        return $this->context->getStatus() === KernelBootstrapStatus::BOOTSTRAPPED;
    }

    private function getPriority(string $bootstrapper): int
    {
        if (!is_subclass_of($bootstrapper, PrioritizedBootstrapperInterface::class)) {
            return 0;
        }

        return $bootstrapper::priority();
    }
}