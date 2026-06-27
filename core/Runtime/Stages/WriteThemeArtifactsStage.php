<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Throwable;
use RuntimeException;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Artifacts\FileArtifactWriter;
use Rombt\ThemeCore\Artifacts\ThemeBuildPathResolver;
use Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Theme\ThemeDefinition;

final class WriteThemeArtifactsStage implements StageInterface
{
    public function __construct(
        private readonly ConfigurationInterface $configuration
    ) {
    }

    public function execute(
        ExecutionContext $context,
        Application $app
    ): StageResult {
        try {
            $theme = $context->session()->theme();

            if (!$theme instanceof ThemeDefinition) {
                throw new RuntimeException(
                    'Theme definition not loaded.'
                );
            }


            $themePath = (
                new ThemeBuildPathResolver((string) $this->configuration->get('paths.build'))
                )->resolveThemePath($theme);

            $writer = new FileArtifactWriter($themePath);

            $writer->write($context->session()->artifacts());

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
