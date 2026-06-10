<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Runtime\Session\BuildSession;
use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;

interface BuildSessionFactoryInterface
{
    public function create(
        LoggerInterface $logger
    ): BuildSession;
}
