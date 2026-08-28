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
    public function __construct(iterable $sources, private ?Application $app)
    {
        $indexed = [];

        $logger = $this->app->getContext()->get(ApplicationContextKeys::LOGGER);

        $logger->dump('class ArtifactSources $sources = ');
        $logger->dump($sources);

        foreach ($sources as $source) {
            $logger->dump('SOURCE CLASS = ');
            $logger->dump($source::class);

            $indexed[$source::class] = $source;
        }


        $logger->dump('class ArtifactSources $indexed = ');
        $logger->dump($indexed);

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
        $logger = $this->app->getContext()->get(
            ApplicationContextKeys::LOGGER
        );

        $logger->dump('GET SOURCE = ');
        $logger->dump($source);

        $logger->dump('isset = ');
        $logger->dump(isset($this->sources[$source]));

        $logger->dump('array_key_exists = ');
        $logger->dump(array_key_exists($source, $this->sources));

        $logger->dump('SOURCES = ');
        $logger->dump($this->sources);

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
