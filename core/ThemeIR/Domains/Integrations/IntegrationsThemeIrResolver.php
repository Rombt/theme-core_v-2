<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Integrations;

use Rombt\ThemeCore\ThemeComponents\Domains\Integrations\IntegrationsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeIrCollection;

final readonly class IntegrationsThemeIrResolver implements ThemeIrResolverInterface
{
    public function supports(ThemeComponent $component): bool
    {
        return $component->component() instanceof IntegrationsComponent;
    }

    public function resolve(ThemeComponent $component): ThemeIrCollection
    {
        /** @var IntegrationsComponent $integrations */
        $integrations = $component->component();

        return new ThemeIrCollection([
            new IntegrationIr(
                id: new IrId($component->id()->value()),
                configuration: $integrations->integrations(),
            ),
        ]);
    }
}
