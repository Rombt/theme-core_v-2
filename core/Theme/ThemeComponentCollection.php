<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

use RuntimeException;
use Rombt\ThemeCore\Theme\ThemeComponent;

final readonly class ThemeComponentCollection
{
    /**
     * @var array<string, ThemeComponent>
     */
    private array $components;

    /**
     * @param iterable<ThemeComponent> $components
     */
    public function __construct(
        iterable $components = [],
    ) {
        $indexed = [];

        foreach ($components as $component) {
            $indexed[$component->id()->value()] = $component;
        }

        $this->components = $indexed;
    }

    public function has(
        ComponentId $id,
    ): bool {
        return isset($this->components[$id->value()]);
    }

    public function get(
        ComponentId $id,
    ): ThemeComponent {
        $component = $this->components[$id->value()] ?? null;

        if ($component === null) {
            throw new RuntimeException(
                sprintf(
                    'Component "%s" is not defined.',
                    $id->value(),
                ),
            );
        }

        return $component;
    }

    /**
     * @return array<string, ThemeComponent>
     */
    public function all(): array
    {
        return $this->components;
    }
}
