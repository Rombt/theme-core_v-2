<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Definitions\MenuDefinition;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Definitions\SidebarDefinition;

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
            menu: $this->createMenuDefinition($node),
            sidebar: $this->createSidebarDefinition($node),
            rendering: isset($node['rendering'])
                ? (string) $node['rendering']
                : null,
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
            $result[$node->id()] = $this->nodeToArray($node);
        }

        return $result;
    }

    /**
     * @return array<string, mixed>
     */
    private function nodeToArray(Node $node): array
    {
        return [
            'type' => $node->type()->value(),
            'resource' => $node->resource(),
            'name' => $node->name(),
            'strategy' => $node->strategy(),
            'description' => $node->description(),
            'capabilities' => $node->capabilities(),
            'metadata' => $node->metadata(),
            'menu' => $this->menuToArray($node),
            'sidebar' => $this->sidebarToArray($node),
            'rendering' => $node->rendering(),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function menuToArray(Node $node): ?array
    {
        return $node->menu()?->toArray();
    }

    /**
     * @return array<string, mixed>|null
     */
    private function sidebarToArray(Node $node): ?array
    {
        return $node->sidebar()?->toArray();
    }

    /**
     * @param array<string, mixed> $node
     */
    private function createMenuDefinition(array $node): ?MenuDefinition
    {
        if (!is_array($node['menu'] ?? null)) {
            return null;
        }

        return new MenuDefinition(
            location: (string) ($node['menu']['location'] ?? ''),
            label: (string) ($node['menu']['label'] ?? ''),
        );
    }

    /**
     * @param array<string, mixed> $node
     */
    private function createSidebarDefinition(array $node): ?SidebarDefinition
    {
        if (!is_array($node['sidebar'] ?? null)) {
            return null;
        }

        return new SidebarDefinition(
            id: (string) ($node['sidebar']['id'] ?? ''),
            name: (string) ($node['sidebar']['name'] ?? ''),
            description: isset($node['sidebar']['description'])
                ? (string) $node['sidebar']['description']
                : null,
        );
    }
}
