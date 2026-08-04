<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR;

use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;

final readonly class ThemeIrResolverRegistry
{
    /**
     * @param ThemeIrResolverInterface[] $resolvers
     */
    public function __construct(
        private array $resolvers,
    ) {
    }

    /**
     * @return ThemeIrResolverInterface[]
     */
    public function resolvers(): array
    {
        return $this->resolvers;
    }
}
