<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Throwable;
use Rombt\ThemeCore\Artifacts\ArtifactSources;
use Rombt\ThemeCore\Artifacts\Contracts\ThemeArtifactGeneratorInterface;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\SessionKeys;
use Rombt\ThemeCore\ThemeIR\ThemeIR;

final class GenerateIrArtifactsStage implements StageInterface
{
    public function __construct(private readonly ThemeArtifactGeneratorInterface $generator)
    {
    }

    public function execute(ExecutionContext $context, Application $app): StageResult
    {

        try {
            $session = $context->session();

            $ir = $session->getResource(SessionKeys::THEME_IR);


            $logger = $app->getContext()->get(ApplicationContextKeys::LOGGER);

            $logger->dump('GenerateIrArtifactsStage    $ir = ');
            $logger->dump($ir);

            // $logger->dump('ThemeIR::class = ');
            // $logger->dump(ThemeIR::class);

            // $logger->dump('$ir::class = ');
            // $logger->dump($ir::class);

            if (!$ir instanceof ThemeIR) {
                throw new RuntimeException('Theme IR not built.');
            }

            $sources = new ArtifactSources(
                [
                    $session->package(),
                    $ir,

                ],
                $app
            );

            $this->generator->generate($sources, $session->artifacts());


            return new StageResult(
                success: true,
                metadata: [
                    'artifact_count' => $session
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
