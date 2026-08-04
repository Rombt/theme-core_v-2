<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Domains\Templates;

use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\Composition;

final readonly class Template
{
    public function __construct(
        private string $id,
        private Composition $composition,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function composition(): Composition
    {
        return $this->composition;
    }
}
