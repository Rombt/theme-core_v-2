<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme\Domains\Templates;

use Rombt\ThemeCore\Theme\ComponentId;
use Rombt\ThemeCore\Theme\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\Theme\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Templates\TemplatesConfiguration;

final readonly class TemplatesComponentBuilder implements ThemeComponentBuilderInterface
{
    public function supports(
        ConfigurationDomain $domain,
    ): bool {
        return $domain->configuration() instanceof TemplatesConfiguration;
    }

    public function build(
        ConfigurationDomain $domain,
    ): ThemeComponent {
        /** @var TemplatesConfiguration $configuration */
        $configuration = $domain->configuration();

        return new ThemeComponent(
            id: new ComponentId('templates'),
            component: new TemplatesComponent(
                $configuration->templates(),
            ),
        );
    }
}
