<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Planning;

final class DependencyPlan
{
    /**
     * @param string[] $orderedIdentifiers
     */
    public function __construct(
        private readonly array $orderedIdentifiers
    ) {
    }

    /**
     * @return string[]
     */
    public function getOrderedIdentifiers(): array
    {
        return $this->orderedIdentifiers;
    }
}
