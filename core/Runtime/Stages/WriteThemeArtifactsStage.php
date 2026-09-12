<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\ArtifactCollection;
use Rombt\ThemeCore\Artifacts\FileArtifactWriter;
use Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\SessionKeys;

final class WriteThemeArtifactsStage implements StageInterface
{
    public function __construct(
        private readonly ConfigurationInterface $configuration,
    ) {
    }

    public function execute(
        ExecutionContext $context,
        Application $app,
    ): StageResult {
        $logger = $app->getContext()->get(ApplicationContextKeys::LOGGER);

        try {
            $buildPath = (string) $this->configuration->get('paths.build');

            if ($buildPath === '') {
                throw new RuntimeException(
                    'Build path is not configured.',
                );
            }

            $session = $context->session();
            $package = $session->package();
            $themeName = $package->package()->configuration()['name'];
            $artifacts = $session->artifacts();

            $logger->dump('WriteThemeArtifactsStage    $artifacts = ',);
            $logger->dump($artifacts);

            $classicArtifacts = new ArtifactCollection();
            $blockArtifacts = new ArtifactCollection();

            foreach ($artifacts as $artifact) {
                $architecture = $artifact->metadata()['architecture'] ?? null;

                if ($architecture === 'classic') {
                    $classicArtifacts->add($artifact);
                    continue;
                }

                if ($architecture === 'block') {
                    $blockArtifacts->add($artifact);
                    continue;
                }

                if ($architecture === 'shared') {
                    $classicArtifacts->add($artifact);
                    $blockArtifacts->add($artifact);
                    continue;
                }

                throw new RuntimeException(
                    sprintf(
                        'Artifact "%s" does not define a supported architecture.',
                        $artifact->id()->value(),
                    ),
                );
            }

            $buildRoot = rtrim($buildPath, '/\\');

            $classicThemePath = sprintf(
                '%s/%s/%s',
                $buildRoot,
                'classic',
                $themeName,
            );

            $blockThemePath = sprintf(
                '%s/%s/%s',
                $buildRoot,
                'block',
                $themeName,
            );

            /** @var list<string> $themeBuildPaths */
            $themeBuildPaths = [];

            if ($classicArtifacts->count() > 0) {
                $classicWriter = new FileArtifactWriter(
                    $classicThemePath,
                );

                $classicWriter->write($classicArtifacts);

                $themeBuildPaths[] = $classicThemePath;
            }

            if ($blockArtifacts->count() > 0) {
                $blockWriter = new FileArtifactWriter(
                    $blockThemePath,
                );

                $blockWriter->write($blockArtifacts);

                $themeBuildPaths[] = $blockThemePath;
            }

            $session->setResource(
                SessionKeys::THEME_BUILD_PATHS,
                $themeBuildPaths,
            );

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
