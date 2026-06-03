<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Contracts;

interface ServiceComposerInterface
{
    public function get(string $identifier): object;
}
