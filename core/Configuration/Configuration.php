<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Configuration;

final class Configuration
{
    public function __construct(
        private readonly string $projectRoot,
    ) {
    }

    public function projectRoot(): string
    {
        return $this->projectRoot;
    }
}