<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Artifacts\ArtifactCollection;
use Rombt\ThemeCore\Artifacts\FileArtifactWriter;
use Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Result\StageResult;

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
        try {
            $buildPath = (string) $this->configuration->get('paths.build');

            if ($buildPath === '') {
                throw new RuntimeException(
                    'Build path is not configured.',
                );
            }

            $package = $context->session()->package();

            $themeName = $package
                ->package()
                ->configuration()['name'];

            $artifacts = $context->session()->artifacts();

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

            if ($classicArtifacts->count() > 0) {
                $classicWriter = new FileArtifactWriter(
                    $classicThemePath,
                );

                $classicWriter->write(
                    $classicArtifacts,
                );
            }

            if ($blockArtifacts->count() > 0) {
                $blockWriter = new FileArtifactWriter(
                    $blockThemePath,
                );

                $blockWriter->write(
                    $blockArtifacts,
                );
            }

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
