<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Theme\ThemeDefinition;
use Rombt\ThemeCore\Theme\ThemeIr;

final class CompositionArtifactGenerator implements ArtifactGeneratorInterface
{
    public function generate(
        ThemeIr $ir,
        ArtifactCollectionInterface $artifacts,
    ): void {
        foreach ($ir->compositions() as $id => $composition) {
            $type = $composition['type'] ?? 'template';

            $destination = $type === 'template-part'
            ? sprintf('parts/%s.html', $id)
            : sprintf('templates/%s.html', $id);

            $artifacts->add(
                new Artifact(
                    id: new ArtifactId(sprintf('composition-%s', $id)),
                    type: ArtifactType::FILE,
                    destination: $destination,
                    content: '',
                )
            );
        }
    }
}
