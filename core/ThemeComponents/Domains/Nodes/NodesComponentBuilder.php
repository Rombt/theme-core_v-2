<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeComponents\Domains\Rendering\Rendering;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\Node as ConfigurationNode;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\NodesConfiguration;

final readonly class NodesComponentBuilder implements ThemeComponentBuilderInterface
{
    public function supports(
        ConfigurationDomain $domain,
    ): bool {
        return $domain->configuration() instanceof NodesConfiguration;
    }

    public function build(
        ConfigurationDomain $domain,
    ): ThemeComponent {
        /** @var NodesConfiguration $configuration */
        $configuration = $domain->configuration();

        $nodes = [];

        foreach ($configuration->nodes() as $configurationNode) {
            $nodes[] = $this->buildNode(
                $configurationNode,
            );
        }

        return new ThemeComponent(
            id: new ComponentId('nodes'),
            component: new NodesComponent(
                new NodeCollection($nodes),
            ),
        );
    }

    private function buildNode(
        ConfigurationNode $node,
    ): Node {
        return new Node(
            id: $node->id(),
            type: new NodeType(
                name: $node->type()->name(),
                strategy: NodeStrategy::fromString(
                    $node->type()->strategy(),
                ),
            ),
            resource: $node->resource(),
            name: $node->name(),
            strategy: $node->hasStrategyOverride()
                ? NodeStrategy::fromString($node->strategy())
                : null,
            description: $node->description(),
            capabilities: $node->capabilities(),
            metadata: $node->metadata(),
            menu: $node->menu(),
            sidebar: $node->sidebar(),
            rendering: $node->rendering() !== null
                ? Rendering::from($node->rendering())
                : null,
        );
    }
}
