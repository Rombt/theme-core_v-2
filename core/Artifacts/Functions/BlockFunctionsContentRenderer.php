<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Functions;

use LogicException;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Functions\Contracts\FunctionsContentRendererInterface;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\FunctionsInterface;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\Resource;

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
                $item['resourceType'],
            );

            if ($content === null || trim($content) === '') {
                continue;
            }

            $content = $this->normalizeResourceContent($content);

            if ($content === '') {
                continue;
            }

            $contents[] = $content;
        }

        if ($contents === []) {
            return "<?php\n\n";
        }

        return "<?php\n\n"
            . implode("\n\n", $contents)
            . "\n";
    }

    /**
     * @return array<int, array{
     *     resource: Resource,
     *     resourceType: string,
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
                'resourceType' => 'functions',
                'order' => (int) ($configuration['order'] ?? 0),
                'sequence' => $sequence++,
            ];
        }

        foreach ($functions->requirements() as $requirement) {
            $resource = $requirement->resource();

            $items[] = [
                'resource' => $resource,
                'resourceType' => $this->resolveRequirementResourceType($resource),
                'order' => $requirement->order(),
                'sequence' => $sequence++,
            ];
        }

        return $items;
    }

    private function resolveRequirementResourceType(Resource $resource): string
    {
        if (str_starts_with($resource->value(), 'assets/')) {
            return 'assets';
        }

        return 'components';
    }

    private function readResource(
        Resource $resource,
        string $resourceType,
    ): ?string {
        $resourceId = $resource->value();

        $path = $this->resolveResourcePath(
            $resourceId,
            $resourceType,
        );

        if (!is_file($path)) {
            $this->diagnose(
                sprintf(
                    'Block function resource "%s" was not found.',
                    $path,
                ),
                [
                    'resource' => $resourceId,
                    'resourceType' => $resourceType,
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
                    'resourceType' => $resourceType,
                    'architecture' => 'block',
                    'path' => $path,
                ],
            );

            return null;
        }

        return $content;
    }

    private function resolveResourcePath(
        string $resourceId,
        string $resourceType,
    ): string {
        return match ($resourceType) {
            'functions' => $this->functionsResourcePath($resourceId),
            'components' => $this->componentResourcePath($resourceId),
            'assets' => $this->assetResourcePath($resourceId),
            default => throw new LogicException(
                sprintf(
                    'Unknown function resource type "%s".',
                    $resourceType,
                ),
            ),
        };
    }

    private function functionsResourcePath(string $resourceId): string
    {
        return
            rtrim($this->resourcePackage, '/\\')
            . DIRECTORY_SEPARATOR
            . 'functions'
            . DIRECTORY_SEPARATOR
            . $resourceId
            . DIRECTORY_SEPARATOR
            . $resourceId . '.block.html';
    }

    private function componentResourcePath(string $resourceId): string
    {
        return
            rtrim($this->resourcePackage, '/\\')
            . DIRECTORY_SEPARATOR
            . 'components'
            . DIRECTORY_SEPARATOR
            . $resourceId
            . DIRECTORY_SEPARATOR
            . 'function.block.html';
    }

    private function assetResourcePath(string $resourceId): string
    {
        return
            rtrim($this->resourcePackage, '/\\')
            . DIRECTORY_SEPARATOR
            . $resourceId
            . DIRECTORY_SEPARATOR
            . 'block'
            . DIRECTORY_SEPARATOR
            . 'function.block.php';
    }

    private function normalizeResourceContent(string $content): string
    {
        $content = trim($content);

        if ($content === '') {
            return '';
        }

        if (str_starts_with($content, '<?php')) {
            $content = substr($content, 5);
        }

        return trim($content);
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
