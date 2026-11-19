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

    /**
     * These values must stay aligned with the AssetType enums in ThemeComponents
     * and ThemeIR. ThemeConfiguration intentionally has no dependency on either layer.
     *
     * @var list<string>
     */
    private const array SUPPORTED_ASSET_TYPES = ['style', 'script', 'font', 'image'];

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

        $assetIds = [];
        $destinations = [];

        foreach ($configuration->assets() as $asset) {
            $id = $asset->id();

            if (trim($id) === '') {
                throw new RuntimeException('Asset ID must not be empty.');
            }

            if (isset($assetIds[$id])) {
                throw new RuntimeException(
                    sprintf('Duplicate asset ID "%s".', $id),
                );
            }

            $assetIds[$id] = true;

            $type = $asset->type()->value();

            if (trim($type) === '') {
                throw new RuntimeException(
                    sprintf('Asset "%s" must have a type.', $id),
                );
            }

            if (!in_array($type, self::SUPPORTED_ASSET_TYPES, true)) {
                throw new RuntimeException(
                    sprintf(
                        'Asset "%s" has unsupported type "%s". Supported types: %s.',
                        $id,
                        $type,
                        implode(', ', self::SUPPORTED_ASSET_TYPES),
                    ),
                );
            }

            $files = $asset->resource()->files();

            if ($files === []) {
                throw new RuntimeException(
                    sprintf(
                        'Asset "%s" must contain at least one resource file.',
                        $id,
                    ),
                );
            }

            $multipleFiles = count($files) > 1;
            $assetDestination = $asset->destPath();

            if ($multipleFiles && $assetDestination !== '') {
                throw new RuntimeException(
                    sprintf(
                        'Multi-file asset "%s" must define dest_path on each resource file, not on the asset.',
                        $id,
                    ),
                );
            }

            foreach ($files as $file) {
                $sourcePath = $file->path();

                if (trim($sourcePath) === '') {
                    throw new RuntimeException(
                        sprintf(
                            'Resource file path for asset "%s" must not be empty.',
                            $id,
                        ),
                    );
                }

                $fileDestination = $file->destPath();

                if (
                    !$multipleFiles
                    && $fileDestination !== null
                    && $assetDestination !== ''
                ) {
                    throw new RuntimeException(
                        sprintf(
                            'Asset "%s" must define destination either on the asset or on its resource file, not both.',
                            $id,
                        ),
                    );
                }

                $destination = $fileDestination ?? $assetDestination;
                $this->validateDestinationPath($id, $sourcePath, $destination);

                // Destination collisions are checked across the entire Assets domain.
                // Case-insensitive comparison keeps builds deterministic on Windows.
                $destinationKey = strtolower($destination);

                if (isset($destinations[$destinationKey])) {
                    throw new RuntimeException(
                        sprintf(
                            'Duplicate asset destination path "%s" (assets "%s" and "%s").',
                            $destination,
                            $destinations[$destinationKey],
                            $id,
                        ),
                    );
                }

                $destinations[$destinationKey] = $id;
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
            trim($destination) === ''
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
