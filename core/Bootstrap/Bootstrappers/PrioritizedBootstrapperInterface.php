<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

interface PrioritizedBootstrapperInterface extends BootstrapperInterface
{
    public function priority(): int;
}