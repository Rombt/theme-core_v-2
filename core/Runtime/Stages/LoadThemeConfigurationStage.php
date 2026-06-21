<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Theme\Contracts\ThemeConfigurationLoaderInterface;

final class LoadThemeConfigurationStage implements StageInterface
{
    public function __construct(
        private readonly ThemeConfigurationLoaderInterface $loader
    ) {
    }

    public function execute(
        ExecutionContext $context,
        Application $app
    ): StageResult {
        try {
            $theme = $this->loader->load();

            $context
                ->session()
                ->setTheme($theme);

            return new StageResult(
                success: true
            );
        } catch (Throwable $e) {
            return new StageResult(
                success: false,
                error: $e
            );
        }
    }
}
