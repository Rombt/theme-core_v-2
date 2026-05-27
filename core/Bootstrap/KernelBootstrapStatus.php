<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap;

enum KernelBootstrapStatus: string
{
    case BOOTSTRAPPING = 'bootstrapping';
    case BOOTSTRAPPED = 'bootstrapped';
    case FAILED = 'failed';
}