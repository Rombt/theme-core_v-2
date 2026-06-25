<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

use Rombt\ThemeCore\Theme\Contracts\ThemeComponentBuilderInterface;

final readonly class ThemeComponentBuilderRegistry
{
    /**
     * @param iterable<ThemeComponentBuilderInterface> $builders
     */
    public function __construct(private iterable $builders)
    {
    }

    /**
     * @return iterable<ThemeComponentBuilderInterface>
     */
    public function all(): iterable
    {
        return $this->builders;
    }
}
