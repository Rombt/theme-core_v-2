<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime;

use Rombt\ThemeCore\Runtime\Contracts\BuildResultFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;
use Rombt\ThemeCore\Runtime\Contracts\PipelineInterface;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\BuildResult;
use Rombt\ThemeCore\Runtime\Session\RuntimeState;
use Throwable;

final class ExecutionRuntime
{
    public function __construct(
        private BuildSessionFactoryInterface $sessionFactory,
        private BuildResultFactoryInterface $resultFactory
    ) {
    }

    public function run(PipelineInterface $pipeline): BuildResult
    {
        $session = $this->sessionFactory->create();

        try {
            $session->setState(RuntimeState::RUNNING);

            foreach ($pipeline->getStages() as $stage) {
                if (!$stage instanceof StageInterface) {
                    throw new \RuntimeException('Invalid stage provided');
                }

                $stage->execute($session);
            }

            $result = $this->resultFactory->createSuccess($session);

            $session->setResult($result);
            $session->setState(RuntimeState::COMPLETED);

            return $result;
        } catch (Throwable $e) {
            $result = $this->resultFactory->createFailure(
                $session,
                $e
            );

            $session->setResult($result);
            $session->setState(RuntimeState::FAILED);

            return $result;
        }
    }
}
