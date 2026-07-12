<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Templates;

final readonly class Template
{
    public function __construct(
        private string $id,
        private string $composition,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function composition(): string
    {
        return $this->composition;
    }
}
