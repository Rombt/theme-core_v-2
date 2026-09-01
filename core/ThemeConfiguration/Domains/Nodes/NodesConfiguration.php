<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Definitions\FunctionDefinition;

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
            $collection[] = $this->createNode($id, $node);
        }

        $this->nodes = new NodeCollection($collection);
    }

    /**
     * @param array<string, mixed> $node
     */
    private function createNode(string $id, array $node): Node
    {
        return new Node(
            id: $id,
            type: new NodeType(
                value: (string) ($node['type'] ?? ''),
            ),
            resource: isset($node['resource'])
                ? (string) $node['resource']
                : null,
            name: (string) ($node['name'] ?? ''),
            strategy: isset($node['strategy'])
                ? (string) $node['strategy']
                : null,
            description: isset($node['description'])
                ? (string) $node['description']
                : null,
            capabilities: array_values($node['capabilities'] ?? []),
            metadata: is_array($node['metadata'] ?? null)
                ? $node['metadata']
                : [],
            rendering: isset($node['rendering'])
                ? (string) $node['rendering']
                : null,
            function: $this->createFunctionDefinition($node['function'] ?? null),
        );
    }

    /**
     * @param mixed $function
     */
    private function createFunctionDefinition(mixed $function): ?FunctionDefinition
    {
        if (!is_array($function)) {
            return null;
        }

        return new FunctionDefinition(
            enabled: (bool) ($function['enabled'] ?? false),
            order: (int) ($function['order'] ?? 0),
        );
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
                'type' => $node->type()->value(),
                'resource' => $node->resource(),
                'name' => $node->name(),
                'strategy' => $node->strategy(),
                'description' => $node->description(),
                'capabilities' => $node->capabilities(),
                'metadata' => $node->metadata(),
                'rendering' => $node->rendering(),
                'function' => $node->function()?->toArray(),
            ];
        }

        return $result;
    }
}
