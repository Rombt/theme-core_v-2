<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Diagnostics;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticCollector;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticEntry;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticReport;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticReportBuilder;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticReportRenderer;

final class DiagnosticReportingTest extends TestCase
{
    public function testCollectorRetainsEntriesAndCountsTheirSeverities(): void
    {
        $collector = new DiagnosticCollector();
        $error = $this->entry(DiagnosticLevel::ERROR, 'Build failed.');
        $warning = $this->entry(DiagnosticLevel::WARNING, 'Deprecated option.');

        $collector->record($error);
        $collector->record($warning);

        self::assertSame([$error, $warning], $collector->entries());
        self::assertSame(1, $collector->severities()['error']);
        self::assertSame(1, $collector->severities()['warning']);
        self::assertSame(0, $collector->severities()['critical']);
    }

    public function testReportBuilderTransfersSectionsCountsMetadataAndEntries(): void
    {
        $collector = new DiagnosticCollector();
        $entry = $this->entry(DiagnosticLevel::ERROR, 'Missing resource.');
        $collector->record($entry);
        $collector->section('Bootstrap')->set('composition_loaded', true);
        $collector->setMetadata('project', 'fixture');

        $report = (new DiagnosticReportBuilder())->build($collector);

        self::assertSame([$entry], $report->entries());
        self::assertSame(['composition_loaded' => true], $report->section('Bootstrap'));
        self::assertSame('fixture', $report->metadata()['project']);
        self::assertSame(1, $report->severities()['error']);
    }

    public function testRendererIncludesEntryDetailsAndSeveritySummary(): void
    {
        $entry = $this->entry(
            DiagnosticLevel::ERROR,
            'Template resource was not found.',
            ['template' => 'header', 'resource' => 'templates/header.php'],
            ['operation' => 'materialize'],
        );
        $collector = new DiagnosticCollector();
        $collector->record($entry);

        $output = (new DiagnosticReportRenderer())->render(
            (new DiagnosticReportBuilder())->build($collector)
        );

        self::assertStringContainsString('Entries', $output);
        self::assertStringContainsString('[ERROR]', $output);
        self::assertStringContainsString('Template resource was not found.', $output);
        self::assertStringContainsString('"template":"header"', $output);
        self::assertStringContainsString('"operation":"materialize"', $output);
        self::assertStringContainsString('ERROR: 1', $output);
    }

    public function testRendererHandlesAnEmptyEntryList(): void
    {
        $report = new DiagnosticReport([], [], []);
        $output = (new DiagnosticReportRenderer())->render($report);

        self::assertStringContainsString('No diagnostic entries.', $output);
    }

    public function testReportConstructorRemainsCompatibleWithoutEntriesArgument(): void
    {
        $report = new DiagnosticReport([], [], []);

        self::assertSame([], $report->entries());
    }

    /**
     * @param array<string, mixed> $context
     * @param array<string, mixed> $metadata
     */
    private function entry(
        DiagnosticLevel $level,
        string $message,
        array $context = [],
        array $metadata = [],
    ): DiagnosticEntry {
        return new DiagnosticEntry(
            level: $level,
            message: $message,
            context: new DiagnosticContext($context),
            metadata: $metadata,
            timestamp: new \DateTimeImmutable('2026-11-12T14:00:00+02:00'),
        );
    }
}
