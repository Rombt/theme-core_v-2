<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

interface StartupPhaseInterface
{
    public function execute(): void;
}
