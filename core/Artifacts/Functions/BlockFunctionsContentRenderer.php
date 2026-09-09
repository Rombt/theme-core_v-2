<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Functions;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Functions\Contracts\FunctionsContentRendererInterface;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
// use Rombt\ThemeCore\ThemeIR\Concepts\Functions\Functions;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\Resource;
use Rombt\ThemeCore\ThemeIR\ThemeIR;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\FunctionsInterface;

final readonly class BlockFunctionsContentRenderer implements FunctionsContentRendererInterface
{
    private string $resourcePackage;

    private DiagnosticsService $diagnostics;

    public function __construct(Application $app)
    {
        $context = $app->getContext();

        $configuration = $context->get(
            ApplicationContextKeys::CONFIGURATION,
        );

        $this->resourcePackage = $configuration->get(
            'theme.resource_package',
        );

        $this->diagnostics = $context->get(
            ApplicationContextKeys::DIAGNOSTICS,
        );
    }

    public function render(FunctionsInterface $functions): string
    {
        $items = $this->collectItems($functions);

        usort(
            $items,
            static function (array $a, array $b): int {
                $orderComparison = $a['order'] <=> $b['order'];

                if ($orderComparison !== 0) {
                    return $orderComparison;
                }

                return $a['sequence'] <=> $b['sequence'];
            },
        );

        $contents = [];

        foreach ($items as $item) {
            $content = $this->readResource(
                $item['resource'],
            );

            if ($content === null || trim($content) === '') {
                continue;
            }

            $contents[] = trim($content);
        }

        if ($contents === []) {
            return "<?php\n\ndeclare(strict_types=1);\n";
        }

        return "<?php\n\ndeclare(strict_types=1);\n\n"
            . implode("\n\n", $contents)
            . "\n";
    }

    /**
     * @return array<int, array{
     *     resource: Resource,
     *     order: int,
     *     sequence: int
     * }>
     */
    private function collectItems(FunctionsInterface $functions): array
    {
        $items = [];
        $sequence = 0;

        foreach ($functions->declarations() as $declaration) {
            $configuration = $declaration->configuration();
            $resource = $declaration->resource();

            if ($resource === null) {
                continue;
            }

            $items[] = [
            'resource' => $resource,
            'order' => (int) ($configuration['order'] ?? 0),
            'sequence' => $sequence++,
            ];
        }

        foreach ($functions->requirements() as $requirement) {
            $items[] = [
            'resource' => $requirement->resource(),
            'order' => $requirement->order(),
            'sequence' => $sequence++,
            ];
        }

        return $items;
    }

    private function readResource(Resource $resource): ?string
    {
        $resourceId = $resource->value();

        $path = $this->resourcePath(
            $resourceId,
            'function.block.html',
        );

        if (!is_file($path)) {
            $this->diagnose(
                sprintf(
                    'Block function resource "%s" was not found.',
                    $path,
                ),
                [
                'resource' => $resourceId,
                'architecture' => 'block',
                'path' => $path,
                ],
            );

            return null;
        }

        $content = file_get_contents($path);

        if ($content === false) {
            $this->diagnose(
                sprintf(
                    'Unable to read Block function resource "%s".',
                    $path,
                ),
                [
                'resource' => $resourceId,
                'architecture' => 'block',
                'path' => $path,
                ],
            );

            return null;
        }

        return $content;
    }

    private function resourcePath(
        string $resourceId,
        string $filename,
    ): string {
        return rtrim(
            $this->resourcePackage,
            '/\\',
        )
            . DIRECTORY_SEPARATOR
            . 'components'
            . DIRECTORY_SEPARATOR
            . $resourceId
            . DIRECTORY_SEPARATOR
            . $filename;
    }

    /**
     * @param array<string, mixed> $metadata
     */
    private function diagnose(
        string $message,
        array $metadata = [],
    ): void {
        $this->diagnostics->create(
            level: DiagnosticLevel::ERROR,
            message: $message,
            context: new DiagnosticContext($metadata),
            metadata: $metadata,
        );
    }
}
