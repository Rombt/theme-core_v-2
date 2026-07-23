<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Compositions;

use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsConfiguration;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\NodeCollection;

final readonly class CompositionsComponentBuilder implements ThemeComponentBuilderInterface
{
    public function __construct(
        private CompositionCollectionBuilder $builder = new CompositionCollectionBuilder(),
    ) {
    }

    public function supports(
        ConfigurationDomain $domain,
    ): bool {
        return $domain->configuration() instanceof CompositionsConfiguration;
    }

    public function build(
        ConfigurationDomain $domain,
        ThemeComponentCollection $components,
    ): ThemeComponent {
        /** @var CompositionsConfiguration $configuration */
        $configuration = $domain->configuration();

        return new ThemeComponent(
            id: new ComponentId('compositions'),
            component: new CompositionsComponent(
                $this->builder->build(
                    $configuration,
                    new NodeCollection(),
                ),
            ),
        );
    }
}
