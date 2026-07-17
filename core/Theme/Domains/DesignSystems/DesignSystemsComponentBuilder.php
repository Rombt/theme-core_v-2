<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme\Domains\DesignSystems;

use Rombt\ThemeCore\Theme\ComponentId;
use Rombt\ThemeCore\Theme\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\Theme\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Domains\DesignSystems\DesignSystemsConfiguration;

final readonly class DesignSystemsComponentBuilder implements ThemeComponentBuilderInterface
{
    public function supports(
        ConfigurationDomain $domain,
    ): bool {
        return $domain->configuration() instanceof DesignSystemsConfiguration;
    }

    public function build(
        ConfigurationDomain $domain,
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
