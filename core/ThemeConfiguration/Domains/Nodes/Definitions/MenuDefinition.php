<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Definitions;

final readonly class MenuDefinition
{
    public function __construct(
        private string $location,
        private string $label,
    ) {
    }

    public function location(): string
    {
        return $this->location;
    }

    public function label(): string
    {
        return $this->label;
    }

    /**
     * @return array{
     *     location: string,
     *     label: string
     * }
     */
    public function toArray(): array
    {
        return [
            'location' => $this->location,
            'label' => $this->label,
        ];
    }
}
