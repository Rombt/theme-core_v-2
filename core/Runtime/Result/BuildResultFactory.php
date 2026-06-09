<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Result;

use Throwable;
use Rombt\ThemeCore\Runtime\Contracts\BuildResultFactoryInterface;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

final class BuildResultFactory implements BuildResultFactoryInterface
{
    public function createSuccess(BuildSession $session): BuildResult
    {
        $result = $session->getBuildResult();

        return $result ?? new BuildResult(
            status: 'completed',
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
            status: 'failed',
            error: $error,
            metadata: [
                'session_id' => $session->getId(),
            ]
        );
    }
}
