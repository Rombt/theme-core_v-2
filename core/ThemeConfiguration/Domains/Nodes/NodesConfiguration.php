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
            /** @var array{name?: string, strategy?: string} $type */
            $type = is_array($node['type'] ?? null)
                ? $node['type']
                : [];

            $collection[] = new Node(
                id: $id,
                type: new NodeType(
                    name: (string) ($type['name'] ?? ''),
                    strategy: isset($type['strategy'])
                        ? (string) $type['strategy']
                        : null,
                ),
                resource: (string) ($node['resource'] ?? ''),
                name: (string) ($node['name'] ?? ''),
                description: isset($node['description'])
                    ? (string) $node['description']
                    : null,
                capabilities: array_values($node['capabilities'] ?? []),
                metadata: is_array($node['metadata'] ?? null)
                    ? $node['metadata']
                    : [],
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
                'type' => [
                    'name' => $node->type()->name(),
                    'strategy' => $node->type()->strategy(),
                ],
                'resource' => $node->resource(),
                'name' => $node->name(),
                'description' => $node->description(),
                'capabilities' => $node->capabilities(),
                'metadata' => $node->metadata(),
            ];
        }

        return $result;
    }
}
