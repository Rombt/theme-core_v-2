<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentInterface;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\NodeCollection;

final readonly class NodesComponent implements ThemeComponentInterface
{
    public function __construct(
        private NodeCollection $nodes,
        private ResolvedResourceCollection $resources = new ResolvedResourceCollection(),
    ) {
    }

    public function nodes(): NodeCollection
    {
        return $this->nodes;
    }

    public function resources(): ResolvedResourceCollection
    {
        return $this->resources;
    }
}
