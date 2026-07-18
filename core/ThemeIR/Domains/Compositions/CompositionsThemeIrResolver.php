<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Compositions;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponent;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrResolverInterface;
use Rombt\ThemeCore\ThemeIR\ThemeIrCollection;

final readonly class CompositionsThemeIrResolver implements ThemeIrResolverInterface
{
    public function __construct(private Application $app)
    {
    }

    public function supports(ThemeComponent $component): bool
    {

        return $component->component() instanceof CompositionsComponent;
    }

    public function resolve(ThemeComponent $component): ThemeIrCollection
    {
        /** @var CompositionsComponent $component */

        return new ThemeIrCollection();
    }
}
