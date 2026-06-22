<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Theme\Contracts\ThemeConfigurationLoaderInterface;
use Rombt\ThemeCore\Theme\ThemeDefinitionFactory;

final class LoadThemeConfigurationStage implements StageInterface
{
    public function __construct(
        private readonly ThemeConfigurationLoaderInterface $loader,
        private readonly ThemeDefinitionFactory $definitions,
    ) {
    }

    public function execute(
        ExecutionContext $context,
        Application $app
    ): StageResult {
        try {
            $configuration = $this->loader->load();

            $theme = $this->definitions->create(
                $configuration
            );

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
