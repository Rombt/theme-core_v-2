<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Integrations;

use RuntimeException;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\Integrations\IntegrationsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeConceptInterface;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIRresolverInterface;
use Rombt\ThemeCore\ThemeIR\IrId;

final readonly class IntegrationsThemeIrResolver implements ThemeIrResolverInterface
{
    public function resolve(
        ThemeComponentCollection $components,
    ): ThemeConceptInterface {
        $themeComponent = $components->find(
            new ComponentId('integrations'),
        );

        if ($themeComponent === null) {
            throw new RuntimeException(
                'Theme component "integrations" not found.',
            );
        }

        $component = $themeComponent->component();

        if (!$component instanceof IntegrationsComponent) {
            throw new RuntimeException(
                'Theme component "integrations" must contain IntegrationsComponent.',
            );
        }

        return new IntegrationIr(
            id: new IrId('integrations'),
            configuration: $component->integrations(),
        );
    }
}
