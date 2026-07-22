<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;

final readonly class NodesConfiguration implements ConfigurationDomainInterface
{
    private NodeCollection $nodes;

    /**
     * @param array<string, array<string, mixed>> $nodes
     */
    public function __construct(array $nodes)
    {
        $collection = [];

        foreach ($nodes as $id => $node) {
            $collection[] = new Node(
                id: $id,
                type: $node['type'] ?? [],
                name: (string) ($node['name'] ?? ''),
                description: $node['description'] ?? null,
                capabilities: array_values($node['capabilities'] ?? []),
                metadata: $node['metadata'] ?? [],
            );
        }

        $this->nodes = new NodeCollection($collection);
    }

    public function nodes(): NodeCollection
    {
        return $this->nodes;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function toArray(): array
    {
        $result = [];

        foreach ($this->nodes as $node) {
            $result[$node->id()] = [
                'type' => $node->type(),
                'name' => $node->name(),
                'description' => $node->description(),
                'capabilities' => $node->capabilities(),
                'metadata' => $node->metadata(),
            ];
        }

        return $result;
    }
}
