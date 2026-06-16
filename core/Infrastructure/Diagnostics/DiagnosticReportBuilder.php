<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Diagnostics;

final class DiagnosticReportBuilder
{
    public function build(
        DiagnosticCollector $collector
    ): DiagnosticReport {

        $sections = [];

        foreach ($collector->sections() as $name => $section) {
            $sections[$name] = $section->all();
        }

        return new DiagnosticReport(
            sections: $sections,
            severities: $collector->severities(),
            metadata: $collector->metadata(),
        );
    }
}
