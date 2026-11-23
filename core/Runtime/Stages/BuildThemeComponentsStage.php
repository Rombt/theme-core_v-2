<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface;
use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\ThemeComponents\Preparation\ThemeComponentResourcePreparer;
use Rombt\ThemeCore\ThemeConfiguration\ThemeArchitecture;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\SessionKeys;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentCollectionBuilderInterface;

final class BuildThemeComponentsStage implements StageInterface
{
    public function __construct(
        private readonly ThemeComponentCollectionBuilderInterface $builder,
        private readonly ThemeComponentResourcePreparer $resourcePreparer,
    ) {
    }

    public function execute(ExecutionContext $context, Application $app): StageResult
    {
        try {
            // !! log !!
            $logger = $app->getContext()->get(ApplicationContextKeys::LOGGER);

            $logger->dump('BuildThemeComponentsStage    $app = ');
            $logger->dump($app);

            $logger->dump('BuildThemeComponentsStage    $context->session()->package() = ');
            $logger->dump($context->session()->package());

            $package = $context->session()->package();
            $components = $this->builder->build($package);

            $configuration = $app->getContext()->get(ApplicationContextKeys::CONFIGURATION);
            $diagnostics = $app->getContext()->get(ApplicationContextKeys::DIAGNOSTICS);

            if (!$configuration instanceof ConfigurationInterface) {
                throw new \RuntimeException('Application configuration is unavailable.');
            }

            if (!$diagnostics instanceof DiagnosticsService) {
                throw new \RuntimeException('Diagnostics service is unavailable.');
            }

            $resourcePackage = $configuration->get('theme.resource_package');
            if (!is_string($resourcePackage) || $resourcePackage === '') {
                throw new \RuntimeException('Configuration field [theme.resource_package] must be a non-empty string.');
            }

            $build = $package->configuration()['build'] ?? [];
            if (!is_array($build)) {
                throw new \RuntimeException('Theme package field [build] must be an array.');
            }

            $strict = $build['strict'] ?? true;
            if (!is_bool($strict)) {
                throw new \RuntimeException('Theme package field [build.strict] must be bool.');
            }

            $this->resourcePreparer->prepare(
                components: $components,
                resourcePackage: $resourcePackage,
                architecture: ThemeArchitecture::fromPackage($package)->value,
                strict: $strict,
                diagnostics: $diagnostics,
            );

            $context->session()->setResource(SessionKeys::THEME_COMPONENTS, $components);

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
