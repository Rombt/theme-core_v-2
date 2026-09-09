<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Functions;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Functions\Contracts\FunctionsContentRendererInterface;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticContext;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticLevel;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\FunctionDeclaration;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\FunctionRequirement;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\Resource;
use Rombt\ThemeCore\ThemeIR\ThemeIR;
use Rombt\ThemeCore\ThemeIR\Concepts\Functions\FunctionsInterface;

final readonly class ClassicFunctionsContentRenderer implements FunctionsContentRendererInterface
{
    private string $resourcePackage;

    private DiagnosticsService $diagnostics;

    public function __construct(private Application $app)
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
        $logger = $this->app->getContext()->get(ApplicationContextKeys::LOGGER);

        $items = $this->collectItems($functions);

        $logger->dump('00 $items = ');
        $logger->dump($items);

        usort(
            $items,
            static fn(array $a, array $b): int =>
            $a['order'] <=> $b['order'],
        );

        $logger->dump('11 $items = ');
        $logger->dump($items);

        $contents = [];

        foreach ($items as $item) {
            $content = $this->readResource(
                $item['resource'],
                $item['resourceType'],
            );

            if ($content === null || trim($content) === '') {
                continue;
            }

            $contents[] = $this->normalizeResourceContent($content);
        }

        $logger->dump('$contents = ');
        $logger->dump($contents);

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
    *     resourceType: string,
    *     order: int
    * }>
    */
    private function collectItems(FunctionsInterface $functions): array
    {
        $items = [];

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
            ];
        }

        foreach ($functions->requirements() as $requirement) {
            $items[] = [
            'resource' => $requirement->resource(),
            'resourceType' => 'components',
            'order' => $requirement->order(),
            ];
        }

        return $items;
    }


    private function readResource(Resource $resource, string $resourceType): ?string
    {
        $logger = $this->app->getContext()->get(ApplicationContextKeys::LOGGER);

        $resourceId = $resource->value();

        $path = $this->resolveResourcePath($resource, $resourceType);

        if (!is_file($path)) {
            $logger->dump('ClassicFunctionsContentRenderer    $path = ');
            $logger->dump($path);

            $this->diagnose(
                sprintf(
                    'Classic function resource "%s" was not found.',
                    $path,
                ),
                [
                    'resource' => $resourceId,
                    'resourceType' => $resourceType,
                    'architecture' => 'classic',
                    'path' => $path,
                ],
            );

            return null;
        }

        $content = file_get_contents($path);

        if ($content === false) {
            $this->diagnose(
                sprintf(
                    'Unable to read Classic function resource "%s".',
                    $path,
                ),
                [
                    'resource' => $resourceId,
                    'resourceType' => $resourceType,
                    'architecture' => 'classic',
                    'path' => $path,
                ],
            );

            return null;
        }

        return $content;
    }

    private function resolveResourcePath(
        Resource $resource,
        string $resourceType,
    ): string {
        $resourceId = $resource->value();

        return match ($resourceType) {
            'functions' => $this->functionsResourcePath($resourceId),
            'components' => $this->componentResourcePath($resourceId),
            default => throw new LogicException(
                sprintf('Unknown function resource type "%s".', $resourceType),
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
            . $resourceId . '.classic.php';
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
            . 'function.classic.php';
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
