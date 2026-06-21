<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Artifacts\Contracts\ArtifactWriterInterface;

final class WriteThemeArtifactsStage implements StageInterface
{
    public function __construct(
        private readonly ArtifactWriterInterface $writer
    ) {
    }

    public function execute(
        ExecutionContext $context,
        Application $app
    ): StageResult {
        try {
            $this->writer->write(
                $context->session()->artifacts()
            );

            return new StageResult(
                success: true,
                metadata: [
                    'artifact_count' => $context
                        ->session()
                        ->artifacts()
                        ->count(),
                ]
            );
        } catch (Throwable $e) {
            return new StageResult(
                success: false,
                error: $e
            );
        }
    }
}
