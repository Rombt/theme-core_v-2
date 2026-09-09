<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactSourcesInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ThemeArtifactGeneratorInterface;

final readonly class ThemeArtifactGenerator implements ThemeArtifactGeneratorInterface
{
    public function __construct(private ArtifactGeneratorRegistry $registry, private Application $app)
    {
    }

    public function generate(
        ArtifactSourcesInterface $sources,
        ArtifactCollectionInterface $artifacts,
    ): void {

        $logger = $this->app->getContext()->get(ApplicationContextKeys::LOGGER);

        // $logger->dump('ThemeArtifactGenerato 00000000000000 ');

        foreach ($this->registry->all() as $generator) {
            $source = $sources->get($generator->source());

            // $logger->dump('ThemeArtifactGenerato    $source = ');
            // $logger->dump($source);
            // $logger->dump('ThemeArtifactGenerato    $generator = ');
            // $logger->dump($generator);

            if ($source === null) {
                continue;
            }

            $generator->generate(
                $source,
                $artifacts,
            );
        }
    }
}
