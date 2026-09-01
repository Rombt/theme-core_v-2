<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Definitions;

final readonly class FunctionDefinition
{
    public function __construct(
        private bool $enabled,
        private int $order,
    ) {
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function order(): int
    {
        return $this->order;
    }

    /**
     * @return array{
     *     enabled: bool,
     *     order: int
     * }
     */
    public function toArray(): array
    {
        return [
            'enabled' => $this->enabled,
            'order' => $this->order,
        ];
    }
}
