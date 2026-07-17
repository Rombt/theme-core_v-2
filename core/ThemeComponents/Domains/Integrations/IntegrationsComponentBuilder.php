<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Integrations;

use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Integrations\IntegrationsConfiguration;

final readonly class IntegrationsComponentBuilder implements ThemeComponentBuilderInterface
{
    public function supports(
        ConfigurationDomain $domain,
    ): bool {
        return $domain->configuration() instanceof IntegrationsConfiguration;
    }

    public function build(
        ConfigurationDomain $domain,
    ): ThemeComponent {
        /** @var IntegrationsConfiguration $configuration */
        $configuration = $domain->configuration();

        return new ThemeComponent(
            id: new ComponentId('integrations'),
            component: new IntegrationsComponent(
                $configuration,
            ),
        );
    }
}
