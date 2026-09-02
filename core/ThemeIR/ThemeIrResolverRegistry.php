<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR;

use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrFinalResolverInterface;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;

final readonly class ThemeIrResolverRegistry
{
    /**
     * @param ThemeIrResolverInterface[] $resolvers
     * @param ThemeIrFinalResolverInterface[] $finalResolvers
     */
    public function __construct(
        private array $resolvers,
        private array $finalResolvers,
    ) {
    }

    /**
     * @return ThemeIrResolverInterface[]
     */
    public function resolvers(): array
    {
        return $this->resolvers;
    }

    /**
     * @return ThemeIrFinalResolverInterface[]
     */
    public function finalResolvers(): array
    {
        return $this->finalResolvers;
    }
}
