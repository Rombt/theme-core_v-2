<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap;

final class KernelState
{
    public const BOOTSTRAP_STATUS = 'kernel.bootstrap.status';
    public const BOOTSTRAP_CURRENT = 'kernel.bootstrap.current';
    public const BOOTSTRAP_FAILED = 'kernel.bootstrap.failed';
    public const BOOTSTRAP_EXCEPTION = 'kernel.bootstrap.exception';
    public const BOOTSTRAPPERS_EXECUTED = 'kernel.bootstrappers.executed';
}