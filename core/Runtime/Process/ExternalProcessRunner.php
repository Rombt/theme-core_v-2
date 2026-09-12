<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Process;

use RuntimeException;
use Rombt\ThemeCore\Runtime\Contracts\ExternalProcessRunnerInterface;
use Symfony\Component\Process\Process;

final class ExternalProcessRunner implements ExternalProcessRunnerInterface
{
    public function run(array $command): void
    {
        $process = new Process($command);

        $process->run();

        if ($process->isSuccessful()) {
            return;
        }

        throw new RuntimeException(
            sprintf(
                "External process failed with exit code %s.\n%s",
                $process->getExitCode(),
                trim($process->getErrorOutput()),
            ),
        );
    }
}
