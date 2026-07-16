<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme\Domains\Compositions;

use Rombt\ThemeCore\Theme\ComponentId;
use Rombt\ThemeCore\Theme\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\Theme\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsConfiguration;

final readonly class CompositionsComponentBuilder implements ThemeComponentBuilderInterface
{
    public function supports(
        ConfigurationDomain $domain,
    ): bool {
        return $domain->configuration() instanceof CompositionsConfiguration;
    }

    public function build(
        ConfigurationDomain $domain,
    ): ThemeComponent {
        /** @var CompositionsConfiguration $configuration */
        $configuration = $domain->configuration();

        return new ThemeComponent(
            id: new ComponentId('compositions'),
            component: new CompositionsComponent(
                $configuration,
            ),
        );
    }
}
