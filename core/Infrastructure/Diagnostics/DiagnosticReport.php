<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Diagnostics;

final class DiagnosticReport
{
    private \DateTimeImmutable $createdAt;

    /**
     * @param array<string, array<string, mixed>> $sections
     * @param array<string, int> $severities
     * @param array<string, mixed> $metadata
     * @param list<DiagnosticEntry> $entries
     */
    public function __construct(
        private readonly array $sections,
        private readonly array $severities,
        private readonly array $metadata,
        private readonly array $entries = [],
    ) {

        $this->createdAt = new \DateTimeImmutable();
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

    /**
     * @return list<DiagnosticEntry>
     */
    public function entries(): array
    {
        return $this->entries;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
