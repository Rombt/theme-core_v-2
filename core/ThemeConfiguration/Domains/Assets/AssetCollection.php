<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Assets;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

final readonly class AssetCollection implements IteratorAggregate, Countable
{
    /**
     * @var array<Asset>
     */
    private array $assets;

    /**
     * @param iterable<Asset> $assets
     */
    public function __construct(iterable $assets = [])
    {
        $this->assets = is_array($assets)
            ? $assets
            : iterator_to_array($assets);
    }

    /**
     * @return Traversable<Asset>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->assets);
    }

    public function count(): int
    {
        return count($this->assets);
    }

    /**
     * @return array<Asset>
     */
    public function all(): array
    {
        return $this->assets;
    }
}
