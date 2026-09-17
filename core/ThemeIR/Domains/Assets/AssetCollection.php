<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Assets;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, Asset>
 */
final class AssetCollection implements IteratorAggregate, Countable
{
    /**
     * @param list<Asset> $assets
     */
    public function __construct(
        private readonly array $assets = [],
    ) {
    }

    /**
     * @return list<Asset>
     */
    public function all(): array
    {
        return $this->assets;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->assets);
    }

    public function count(): int
    {
        return count($this->assets);
    }

    public function find(
        string $id,
    ): ?Asset {
        foreach ($this->assets as $asset) {
            if ($asset->id() === $id) {
                return $asset;
            }
        }

        return null;
    }

    public function isEmpty(): bool
    {
        return $this->assets === [];
    }
}
