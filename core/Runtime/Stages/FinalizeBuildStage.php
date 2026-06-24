<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\Runtime\Session\SessionKeys;
use Rombt\ThemeCore\Theme\ThemeDefinition;

final class FinalizeBuildStage implements StageInterface
{
    public function execute(
        ExecutionContext $context,
        Application $app
    ): StageResult {
        try {
            /**
             * 1. get theme definition
             */
            $definition = $context
                ->session()
                ->getResource(SessionKeys::THEME_DEFINITION);

            if (!$definition instanceof ThemeDefinition) {
                throw new \RuntimeException('ThemeDefinition is missing.');
            }

            /**
             * 2. mark session complete
             */
            $context
                ->session()
                ->setState(\Rombt\ThemeCore\Runtime\Session\RuntimeState::COMPLETED);

            /**
             * 3. store final result (optional, но полезно)
             */
            $context
            ->session()
            ->setBuildResult(
                new BuildResult(
                    status: 'success',
                    error: null,
                    metadata: [
                    'theme_definition' => $definition,
                    ]
                )
            );

            return new StageResult(true);
        } catch (Throwable $e) {
            $context
                ->session()
                ->setState(\Rombt\ThemeCore\Runtime\Session\RuntimeState::FAILED);

            return new StageResult(false, $e);
        }
    }
}
