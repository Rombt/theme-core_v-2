<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Diagnostics;

final class Diagnostics
{
    /**
     * @var array<int, string>
     */
    private array $messages = [];

    public function add(string $message): void
    {
        $this->messages[] = $message;
    }

    /**
     * @return array<int, string>
     */
    public function all(): array
    {
        return $this->messages;
    }
}
