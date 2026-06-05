<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

interface BootstrapStepInterface
{
    public function execute(): void;
}
