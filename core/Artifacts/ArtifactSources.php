<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactSourcesInterface;

final readonly class ArtifactSources implements ArtifactSourcesInterface
{
    /**
     * @param iterable<object> $sources
     */
    public function __construct(iterable $sources, private Application $app)
    {
        $indexed = [];

        foreach ($sources as $source) {
            $indexed[$source::class] = $source;
        }

        $this->sources = $indexed;
    }

    /**
     * @var array<class-string, object>
     */
    private array $sources;

    public function has(string $source): bool
    {
        return isset($this->sources[$source]);
    }

    public function get(string $source): ?object
    {

        $logger = $this->app->getContext()->get(ApplicationContextKeys::LOGGER);

        // $logger->dump('ArtifactSources  $this->sources = ');
        // $logger->dump($this->sources);
        // $logger->dump('ArtifactSources  $source = ');
        // $logger->dump($source);


        return $this->sources[$source] ?? null;
    }

    /**
     * @return array<class-string, object>
     */
    public function all(): array
    {
        return $this->sources;
    }
}
