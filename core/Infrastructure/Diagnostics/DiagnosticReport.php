<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Diagnostics;

final class DiagnosticReport
{
    /**
     * @param array<string, array<string, mixed>> $sections
     * @param array<string, int> $severities
     * @param array<string, mixed> $metadata
     */
    public function __construct(
        private readonly array $sections,
        private readonly array $severities,
        private readonly array $metadata,
    ) {
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function sections(): array
    {
        return $this->sections;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function section(
        string $name
    ): ?array {
        return $this->sections[$name] ?? null;
    }

    /**
     * @return array<string, int>
     */
    public function severities(): array
    {
        return $this->severities;
    }

    /**
     * @return array<string, mixed>
     */
    public function metadata(): array
    {
        return $this->metadata;
    }
}
