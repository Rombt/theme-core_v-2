<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

final readonly class TemplateMaterializationResult
{
    /**
     * @param array<int, string> $slots
     */
    public function __construct(private string $content, private array $slots = [])
    {
    }

    public function content(): string
    {
        return $this->content;
    }

    /**
     * @return array<int, string>
     */
    public function slots(): array
    {
        return $this->slots;
    }
}
