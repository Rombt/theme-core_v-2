<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeComponents\Domains\Nodes\Contracts\ResourceResolverInterface;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\NodesConfiguration;

final readonly class NodesComponentBuilder implements ThemeComponentBuilderInterface
{
    public function __construct(
        private ResourceResolverInterface $resolver = new ConventionResourceResolver(),
    ) {
    }

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

        $this->resolver->resolve(
            $configuration->nodes(),
        );

        return new ThemeComponent(
            id: new ComponentId('nodes'),
            component: new NodesComponent(
                $configuration->nodes(),
            ),
        );
    }
}
