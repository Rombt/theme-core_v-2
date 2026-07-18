<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\ThemeIR\Contracts\ThemeIrBuilderInterface;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\SessionKeys;

final readonly class BuildThemeIrStage implements StageInterface
{
    public function __construct(private ThemeIrBuilderInterface $builder)
    {
    }

    public function execute(ExecutionContext $context, Application $app): StageResult
    {
        try {
            $components = $context->session()->getResource(SessionKeys::THEME_COMPONENTS);

            $themeIr = $this->builder->build($components);

            $context->session()->setResource(SessionKeys::THEME_IR, $themeIr);

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
