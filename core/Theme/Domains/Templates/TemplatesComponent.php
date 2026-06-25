<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme\Domains\Templates;

use Rombt\ThemeCore\Theme\Contracts\ThemeComponentInterface;

final readonly class TemplatesComponent implements ThemeComponentInterface
{
    /**
     * @param array<string, array<string, mixed>> $templates
     */
    public function __construct(
        private array $templates,
    ) {
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function templates(): array
    {
        return $this->templates;
    }
}
