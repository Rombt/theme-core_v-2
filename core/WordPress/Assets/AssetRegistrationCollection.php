<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\WordPress\Assets;

use IteratorAggregate;
use ArrayIterator;
use Traversable;

final readonly class AssetRegistrationCollection implements IteratorAggregate
{
    /**
     * @param array<AssetRegistration> $registrations
     */
    public function __construct(
        private array $registrations,
    ) {
    }

    /**
     * @return Traversable<AssetRegistration>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->registrations);
    }
}
