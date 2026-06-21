<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use RuntimeException;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactCollectionInterface;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactWriterInterface;

final class FileArtifactWriter implements ArtifactWriterInterface
{
    public function __construct(
        private readonly string $buildDirectory
    ) {
    }

    public function write(
        ArtifactCollectionInterface $artifacts
    ): void {
        foreach ($artifacts as $artifact) {
            $path = $this->buildDirectory
                . DIRECTORY_SEPARATOR
                . $artifact->destination();

            $directory = dirname($path);

            if (!is_dir($directory)) {
                mkdir(
                    $directory,
                    0777,
                    true
                );
            }

            $result = file_put_contents(
                $path,
                $artifact->content()
            );

            if ($result === false) {
                throw new RuntimeException(
                    sprintf(
                        'Unable to write artifact "%s".',
                        $artifact->id()->value()
                    )
                );
            }
        }
    }
}
