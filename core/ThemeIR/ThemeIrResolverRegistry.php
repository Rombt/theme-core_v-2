<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR;

use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
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

    public function resolverFor(ThemeComponent $component): ThemeIrResolverInterface
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->supports($component)) {
                return $resolver;
            }
        }

        throw new \RuntimeException(
            sprintf(
                'No ThemeIrResolver registered for component "%s".',
                $component->id()->value(),
            ),
        );
    }
}
