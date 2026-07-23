<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\DesignSystems;

use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Domains\DesignSystems\DesignSystemsConfiguration;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;

final readonly class DesignSystemsComponentBuilder implements ThemeComponentBuilderInterface
{
    public function supports(
        ConfigurationDomain $domain,
    ): bool {
        return $domain->configuration() instanceof DesignSystemsConfiguration;
    }

    public function build(
        ConfigurationDomain $domain,
        ThemeComponentCollection $components,
    ): ThemeComponent {
        /** @var DesignSystemsConfiguration $configuration */
        $configuration = $domain->configuration();

        return new ThemeComponent(
            id: new ComponentId('design-systems'),
            component: new DesignSystemsComponent(
                $configuration,
            ),
        );
    }
}
