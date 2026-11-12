<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Diagnostics;

final class DiagnosticReportRenderer
{
    public function render(
        DiagnosticReport $report,
    ): string {
        $lines = [
            '',
            '==================================================',
            sprintf(
                'DIAGNOSTIC REPORT (%s)',
                $report->createdAt()->format('Y-m-d H:i:s'),
            ),
            '==================================================',
        ];

        foreach ($report->sections() as $section => $data) {
            $lines[] = '';
            $lines[] = $section;

            foreach ($data as $key => $value) {
                $lines[] = sprintf(
                    '  %s: %s',
                    $key,
                    $this->stringify($value),
                );
            }
        }

        $lines[] = '';
        $lines[] = 'Entries';

        if ($report->entries() === []) {
            $lines[] = '  No diagnostic entries.';
        } else {
            foreach ($report->entries() as $entry) {
                $lines[] = sprintf(
                    '  [%s] %s',
                    strtoupper($entry->level()->value),
                    $entry->timestamp()->format(DATE_ATOM),
                );
                $lines[] = '    Message: ' . $entry->message();
                $lines[] = '    Context: ' . $this->stringify($entry->context()->all());
                $lines[] = '    Metadata: ' . $this->stringify($entry->metadata());
            }
        }

        $lines[] = '';
        $lines[] = 'Logging';

        foreach ($report->severities() as $level => $count) {
            $lines[] = sprintf(
                '  %s: %d',
                strtoupper($level),
                $count,
            );
        }

        return implode(PHP_EOL, $lines) . PHP_EOL;
    }

    private function stringify(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_scalar($value) || $value === null) {
            return (string) $value;
        }

        return json_encode(
            $value,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
        ) ?: '[complex]';
    }
}
