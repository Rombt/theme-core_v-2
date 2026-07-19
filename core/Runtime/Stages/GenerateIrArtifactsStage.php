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
use Rombt\ThemeCore\ThemeIR\ThemeIrCollection;

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

        $logger = $app->getContext()->get(ApplicationContextKeys::LOGGER);
        $logger->dump('$context->session() = ');
        $logger->dump($context->session());


        try {
            $ir = $context->session()->getResource(
                SessionKeys::THEME_IR,
            );

            if (!$ir instanceof ThemeIrCollection) {
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
