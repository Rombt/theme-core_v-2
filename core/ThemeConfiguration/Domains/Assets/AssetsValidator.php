<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Assets;

use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainValidatorInterface;

final readonly class AssetsValidator implements DomainValidatorInterface
{
    private const int MIN_FUNCTION_ORDER = 0;
    private const int MAX_FUNCTION_ORDER = 100;

    public function validate(ConfigurationDomain $domain): void
    {
        $configuration = $domain->configuration();

        if (!$configuration instanceof AssetsConfiguration) {
            throw new RuntimeException(
                sprintf(
                    'Expected %s, got %s.',
                    AssetsConfiguration::class,
                    $configuration::class,
                ),
            );
        }

        $ids = [];

        foreach ($configuration->assets() as $asset) {
            $id = $asset->id();

            if ($id === '') {
                throw new RuntimeException('Asset ID must not be empty.');
            }

            if (isset($ids[$id])) {
                throw new RuntimeException(
                    sprintf('Duplicate asset ID "%s".', $id),
                );
            }

            $ids[$id] = true;

            if ($asset->type()->value() === '') {
                throw new RuntimeException(
                    sprintf('Asset "%s" must have a type.', $id),
                );
            }

            if ($asset->resource()->path() === '') {
                throw new RuntimeException(
                    sprintf('Asset "%s" must have a resource path.', $id),
                );
            }

            $files = $asset->resource()->files();
            if ($files === []) {
                throw new RuntimeException(
                    sprintf('Asset "%s" must contain at least one resource file.', $id),
                );
            }

            $multipleFiles = count($files) > 1;

            if ($multipleFiles && $asset->destPath() !== '') {
                throw new RuntimeException(
                    sprintf(
                        'Multi-file asset "%s" must define dest_path on each resource file, not on the asset.',
                        $id,
                    ),
                );
            }

            $destinations = [];

            foreach ($files as $file) {
                if ($file->path() === '') {
                    throw new RuntimeException(
                        sprintf('Resource file path for asset "%s" must not be empty.', $id),
                    );
                }

                $fileDestination = $file->destPath();
                $assetDestination = $asset->destPath();

                if (!$multipleFiles && $fileDestination !== null && $assetDestination !== '') {
                    throw new RuntimeException(
                        sprintf(
                            'Asset "%s" must define destination either on the asset or on its resource file, not both.',
                            $id,
                        ),
                    );
                }

                $destination = $fileDestination ?? $assetDestination;
                $this->validateDestinationPath($id, $file->path(), $destination);

                $normalizedDestination = strtolower($destination);
                if (isset($destinations[$normalizedDestination])) {
                    throw new RuntimeException(
                        sprintf(
                            'Asset "%s" contains duplicate destination path "%s".',
                            $id,
                            $destination,
                        ),
                    );
                }

                $destinations[$normalizedDestination] = true;
            }

            foreach ($asset->dependencies() as $dependency) {
                if ($dependency === '') {
                    throw new RuntimeException(
                        sprintf(
                            'Dependency for asset "%s" must not be empty.',
                            $id,
                        ),
                    );
                }
            }

            $function = $asset->function();

            if ($function === null) {
                continue;
            }

            $order = $function->order();

            if (
                $order < self::MIN_FUNCTION_ORDER
                || $order > self::MAX_FUNCTION_ORDER
            ) {
                throw new RuntimeException(
                    sprintf(
                        'Function order for asset "%s" must be between %d and %d.',
                        $id,
                        self::MIN_FUNCTION_ORDER,
                        self::MAX_FUNCTION_ORDER,
                    ),
                );
            }
        }
    }

    private function validateDestinationPath(
        string $assetId,
        string $sourcePath,
        string $destination,
    ): void {
        $segments = explode('/', $destination);

        if (
            $destination === ''
            || trim($destination) !== $destination
            || str_contains($destination, "\0")
            || str_contains($destination, '\\')
            || str_starts_with($destination, '/')
            || preg_match('/^[A-Za-z]:/', $destination) === 1
            || in_array('', $segments, true)
            || in_array('.', $segments, true)
            || in_array('..', $segments, true)
        ) {
            throw new RuntimeException(
                sprintf(
                    'Asset "%s" resource file "%s" must have a valid relative POSIX destination path; got "%s".',
                    $assetId,
                    $sourcePath,
                    $destination,
                ),
            );
        }
    }
}
