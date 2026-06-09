<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Pipeline;

use RuntimeException;
use Rombt\ThemeCore\Runtime\Contracts\PipelineExecutorInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

final class PipelineExecutor implements PipelineExecutorInterface
{
    public function execute(
        PipelineInterface $pipeline,
        BuildSession $session
    ): void {
        foreach ($pipeline->getStages() as $stage) {
            if (!$stage instanceof StageInterface) {
                throw new RuntimeException(
                    'Invalid stage provided'
                );
            }

            $stage->execute($session);
        }
    }
}
