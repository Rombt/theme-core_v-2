<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Runtime\Session\SessionKeys;
use Rombt\ThemeCore\Artifacts\FileArtifactWriter;
use Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
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
            // !! log !!
            $logger = $app->getContext()->get(ApplicationContextKeys::LOGGER);
            $logger->dump('WriteThemeArtifactsStage    $artifacts = ');
            $logger->dump($context->session()->artifacts());


            $buildPath = (string) $this->configuration->get('paths.build');

            if ($buildPath === '') {
                throw new RuntimeException(
                    'Build path is not configured.',
                );
            }

            $package = $context->session()->package();

            $themePath = sprintf(
                '%s/%s',
                rtrim($buildPath, '/\\'),
                $package
                    ->package()
                    ->configuration()['name'],
            );

            $writer = new FileArtifactWriter($themePath);

            $writer->write(
                $context->session()->artifacts(),
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
