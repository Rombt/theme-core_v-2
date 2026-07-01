<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\Theme\ThemeIr;

final class CompositionArtifactGenerator implements ArtifactGeneratorInterface
{
    public function generate(
        ThemeIr $ir,
        ArtifactCollectionInterface $artifacts,
    ): void {
        $compositions = $ir->compositions();

        foreach ($compositions as $id => $composition) {
            $type = $composition['type'] ?? 'template';

            $destination = $type === 'template-part'
                ? sprintf('parts/%s.html', $id)
                : sprintf('templates/%s.html', $id);

            $artifacts->add(
                new Artifact(
                    id: new ArtifactId(sprintf('composition-%s', $id)),
                    type: ArtifactType::FILE,
                    destination: $destination,
                    content: $this->render($composition, $compositions),
                )
            );
        }
    }

    /**
     * @param array<string, mixed> $composition
     * @param array<string, array<string, mixed>> $compositions
     */
    private function render(
        array $composition,
        array $compositions,
    ): string {
        $children = $composition['children'] ?? [];

        if ($children === []) {
            return '';
        }

        $lines = [];

        foreach ($children as $child) {
            if (
                isset($compositions[$child])
                && ($compositions[$child]['type'] ?? null) === 'template-part'
            ) {
                $lines[] = sprintf(
                    '<!-- wp:template-part {"slug":"%s"} /-->',
                    $child
                );

                continue;
            }

            $lines[] = sprintf('<!-- %s -->', $child);
        }

        return implode(PHP_EOL . PHP_EOL, $lines) . PHP_EOL;
    }
}
