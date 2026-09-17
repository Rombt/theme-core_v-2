<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Assets;

use Rombt\ThemeCore\Artifacts\Artifact;
use Rombt\ThemeCore\Artifacts\ArtifactId;
use Rombt\ThemeCore\Artifacts\ArtifactType;
use Rombt\ThemeCore\Artifacts\Assets\Contracts\AssetContentRendererInterface;
use Rombt\ThemeCore\Artifacts\Assets\Contracts\AssetResourceReaderInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactGeneratorInterface;
use Rombt\ThemeCore\ThemeIR\Domains\Assets\AssetIr;
use Rombt\ThemeCore\ThemeIR\ThemeIR;

final readonly class AssetArtifactGenerator implements
    ArtifactGeneratorInterface
{
    public function __construct(
        private AssetResourceReaderInterface $resourceReader,
        private AssetContentRendererInterface $contentRenderer,
        private AssetPathResolver $pathResolver,
        private string $architecture,
    ) {
    }

    public function source(): string
    {
        return ThemeIR::class;
    }

    public function generate(
        object $source,
        ArtifactCollectionInterface $artifacts,
    ): void {
        if (!$source instanceof ThemeIR) {
            return;
        }

        $assetIr = $source->concept(
            AssetIr::class,
        );

        foreach ($assetIr->assets() as $asset) {
            foreach ($asset->resource()->files() as $file) {
                $content = $this->resourceReader->read(
                    $asset,
                    $file,
                );

                $content = $this->contentRenderer->render(
                    $asset,
                    $content,
                );

                $artifacts->add(
                    new Artifact(
                        id: new ArtifactId(
                            sprintf(
                                'asset:%s:%s:%s',
                                $this->architecture,
                                $asset->id(),
                                $file->path(),
                            ),
                        ),
                        type: ArtifactType::FILE,
                        destination: $this->pathResolver->destination(
                            $asset,
                            $file,
                        ),
                        content: $content,
                        metadata: [
                            'architecture' => $this->architecture,
                            'asset' => $asset->id(),
                            'type' => $asset->type()->value,
                            'file' => $file->path(),
                            'role' => 'asset',
                        ],
                    ),
                );
            }
        }
    }
}
