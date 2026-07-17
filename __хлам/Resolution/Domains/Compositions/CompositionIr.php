<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Resolution\Domains\Compositions;

final readonly class CompositionIr
{
    public function __construct(
        private CompositionCollection $compositions,
    ) {
    }

    public function compositions(): CompositionCollection
    {
        return $this->compositions;
    }
}
