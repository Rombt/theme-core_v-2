<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Resolution\ThemeIrBuilder;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\SessionKeys;

final readonly class BuildThemeIrStage implements StageInterface
{
    public function __construct(
        private ThemeIrBuilder $builder,
    ) {
    }

    public function execute(
        ExecutionContext $context,
        Application $app,
    ): StageResult {
        try {
            // $theme = $context->session()->theme();

            // $ir = $this->builder->build($theme);

            // $context->session()->setResource(
            //     SessionKeys::THEME_IR,
            //     $ir,
            // );

            return new StageResult(
                success: true,
            );
        } catch (Throwable $e) {
            return new StageResult(
                success: false,
                error: $e,
            );
        }
    }
}
