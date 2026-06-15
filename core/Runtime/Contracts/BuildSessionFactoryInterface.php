<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

interface BuildSessionFactoryInterface
{
    public function create(
        LoggerInterface $logger,
    ): BuildSession;
}
