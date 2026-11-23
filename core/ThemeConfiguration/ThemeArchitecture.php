<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\ThemePackageInterface;

enum ThemeArchitecture: string
{
    case Classic = 'classic';
    case Block = 'block';

    public static function fromPackage(ThemePackageInterface $package): self
    {
        $configuration = $package->configuration();
        $build = $configuration['build'] ?? [];
        $architectures = is_array($build)
            ? ($build['architectures'] ?? $configuration['architectures'] ?? null)
            : null;

        if (!is_array($architectures) || !array_is_list($architectures) || count($architectures) !== 1) {
            throw new RuntimeException(sprintf(
                'Theme package "%s" must declare exactly one supported architecture in package.php.',
                $package->id()->value(),
            ));
        }

        $architecture = $architectures[0];
        if (!is_string($architecture) || self::tryFrom($architecture) === null) {
            throw new RuntimeException(sprintf(
                'Theme package "%s" declares unsupported architecture "%s". Supported architectures: classic, block.',
                $package->id()->value(),
                is_scalar($architecture) ? (string) $architecture : get_debug_type($architecture),
            ));
        }

        return self::from($architecture);
    }
}
