<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Contracts\ThemeArtifactGeneratorInterface;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\SessionKeys;
use Rombt\ThemeCore\ThemeIR\ThemeIr;

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
            $ir = $context->session()->getResource(SessionKeys::THEME_IR);

            // !! log !!
            $logger = $app->getContext()->get(ApplicationContextKeys::LOGGER);
            $logger->dump('GenerateIrArtifactsStage    $ir = ');
            $logger->dump($ir);

            if (!$ir instanceof ThemeIr) {
                throw new RuntimeException(
                    'Theme IR not built.'
                );
            }

            $this->generator->generate($ir, $context->session()->artifacts());

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
