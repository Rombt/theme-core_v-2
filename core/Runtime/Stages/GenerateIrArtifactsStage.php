<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Artifacts\Contracts\ThemeArtifactGeneratorInterface;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Theme\ThemeDefinition;

final class GenerateIrArtifactsStage implements StageInterface
{
    public function __construct(
        private readonly ThemeArtifactGeneratorInterface $generator,
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

            $this->generator->generate(
                $theme,
                $context->session()->artifacts(),
            );

            return new StageResult(
                success: true,
                metadata: [
                    'artifact_count' => $context
                        ->session()
                        ->artifacts()
                        ->count(),
                ],
            );
        } catch (Throwable $e) {
            return new StageResult(
                success: false,
                error: $e,
            );
        }
    }
}
