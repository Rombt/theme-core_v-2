<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Templates;

use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Templates\TemplatesConfiguration;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;

final readonly class TemplatesComponentBuilder implements ThemeComponentBuilderInterface
{
    public function supports(ConfigurationDomain $domain): bool
    {
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
