<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Resolution;

use Rombt\ThemeCore\Resolution\Contracts\ThemeIrResolverInterface;

final readonly class ThemeIrResolverRegistry
{
    /**
     * @var array<ThemeIrResolverInterface>
     */
    private array $resolvers;

    public function __construct(
        ThemeIrResolverInterface ...$resolvers,
    ) {
        $this->resolvers = $resolvers;
    }

    /**
     * @return iterable<ThemeIrResolverInterface>
     */
    public function all(): iterable
    {
        return $this->resolvers;
    }
}
