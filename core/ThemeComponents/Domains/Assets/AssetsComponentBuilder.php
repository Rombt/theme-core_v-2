<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Assets;

use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Assets\AssetsConfiguration;

final readonly class AssetsComponentBuilder implements ThemeComponentBuilderInterface
{
    public function supports(
        ConfigurationDomain $domain,
    ): bool {
        return $domain->configuration() instanceof AssetsConfiguration;
    }

    public function build(
        ConfigurationDomain $domain,
    ): ThemeComponent {
        /** @var AssetsConfiguration $configuration */
        $configuration = $domain->configuration();

        return new ThemeComponent(
            id: new ComponentId('assets'),
            component: new AssetsComponent(
                $configuration->assets(),
            ),
        );
    }
}
