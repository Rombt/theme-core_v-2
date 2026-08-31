<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Functions;

use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Functions\FunctionDefinition;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Functions\FunctionsConfiguration;

final readonly class FunctionsComponentBuilder implements ThemeComponentBuilderInterface
{
    public function supports(
        ConfigurationDomain $domain,
    ): bool {
        return $domain->configuration() instanceof FunctionsConfiguration;
    }

    public function build(
        ConfigurationDomain $domain,
    ): ThemeComponent {
        /** @var FunctionsConfiguration $configuration */
        $configuration = $domain->configuration();

        $functions = [];

        foreach ($configuration->functions() as $function) {
            $functions[] = new FunctionComponent(
                id: $function->id(),
                type: $function->type(),
                resource: $function->resource(),
                name: $function->name(),
                description: $function->description(),
                configuration: $function->configuration(),
            );
        }

        return new ThemeComponent(
            id: new ComponentId('functions'),
            component: new FunctionsComponent(
                new FunctionComponentCollection($functions),
            ),
        );
    }
}
