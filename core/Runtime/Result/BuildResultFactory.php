<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Result;

use Throwable;
use Rombt\ThemeCore\Runtime\Contracts\BuildResultFactoryInterface;
use Rombt\ThemeCore\Runtime\Session\BuildSession;
use Rombt\ThemeCore\Runtime\Session\RuntimeState;

final class BuildResultFactory implements BuildResultFactoryInterface
{
    public function createSuccess(BuildSession $session): BuildResult
    {
        $result = $session->getBuildResult();

        return $result ?? new BuildResult(
            status: RuntimeState::COMPLETED,
            metadata: [
                'session_id' => $session->getId(),
            ]
        );
    }

    public function createFailure(
        BuildSession $session,
        Throwable $error
    ): BuildResult {
        $result = $session->getBuildResult();

        return $result ?? new BuildResult(
            status: RuntimeState::FAILED,
            error: $error,
            metadata: [
                'session_id' => $session->getId(),
            ]
        );
    }
}
