<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\PackageRegistryInterface;

final readonly class ThemePackageRegistry implements PackageRegistryInterface
{
    /**
     * @var array<string, ThemePackageRegistration>
     */
    private array $registrations;

    /**
     * @param array<string, ThemePackageRegistration> $registrations
     */
    public function __construct(array $registrations = [])
    {
        $this->registrations = $registrations;
    }

    public function has(PackageId $id): bool
    {
        return isset($this->registrations[$id->value()]);
    }

    public function get(PackageId $id): ThemePackageRegistration
    {
        $registration = $this->registrations[$id->value()] ?? null;

        if ($registration === null) {
            throw new RuntimeException(
                sprintf(
                    'Theme package "%s" is not registered.',
                    $id->value(),
                ),
            );
        }

        return $registration;
    }

    /**
     * @return array<string, ThemePackageRegistration>
     */
    public function all(): array
    {
        return $this->registrations;
    }
}
