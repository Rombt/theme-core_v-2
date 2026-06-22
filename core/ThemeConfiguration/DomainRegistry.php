<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainRegistryInterface;

final readonly class DomainRegistry implements DomainRegistryInterface
{
    /**
     * @var array<string, DomainRegistration>
     */
    private array $registrations;

    /**
     * @param array<string, DomainRegistration> $registrations
     */
    public function __construct(
        array $registrations = [],
    ) {
        $this->registrations = $registrations;
    }

    public function has(
        DomainId $id,
    ): bool {
        return isset($this->registrations[$id->value()]);
    }

    public function get(
        DomainId $id,
    ): DomainRegistration {
        $registration = $this->registrations[$id->value()] ?? null;

        if ($registration === null) {
            throw new RuntimeException(
                sprintf(
                    'Domain "%s" is not registered.',
                    $id->value(),
                ),
            );
        }

        return $registration;
    }

    /**
     * @return array<string, DomainRegistration>
     */
    public function all(): array
    {
        return $this->registrations;
    }
}
