<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Diagnostics;

final class DiagnosticCollector
{
    /**
     * @var array<string, DiagnosticSection>
     */
    private array $sections = [];

    /**
     * @var array<string, int>
     */
    private array $severities = [];

    /**
     * @var array<string, mixed>
     */
    private array $metadata = [];

    public function __construct()
    {
        foreach (DiagnosticLevel::cases() as $level) {
            $this->severities[$level->value] = 0;
        }
    }

    public function section(
        string $name
    ): DiagnosticSection {
        return $this->sections[$name]
            ??= new DiagnosticSection();
    }

    public function record(
        DiagnosticEntry $entry
    ): void {
        $this->incrementSeverity(
            $entry->level()
        );
    }

    public function incrementSeverity(
        DiagnosticLevel $level
    ): void {
        $this->severities[$level->value]++;
    }

    public function setMetadata(
        string $key,
        mixed $value
    ): void {
        $this->metadata[$key] = $value;
    }

    /**
     * @return array<string, mixed>
     */
    public function metadata(): array
    {
        return $this->metadata;
    }

    /**
     * @return array<string, DiagnosticSection>
     */
    public function sections(): array
    {
        return $this->sections;
    }

    /**
     * @return array<string, int>
     */
    public function severities(): array
    {
        return $this->severities;
    }
}
