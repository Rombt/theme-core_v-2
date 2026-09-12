<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

interface ExternalProcessRunnerInterface
{
    /**
     * @param list<string> $command
     */
    public function run(array $command): void;
}
