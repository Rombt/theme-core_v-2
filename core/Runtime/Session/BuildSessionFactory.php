<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;
use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;

final class BuildSessionFactory implements BuildSessionFactoryInterface
{
    public function create(LoggerInterface $logger): BuildSession
    {
        return new BuildSession(uniqid('session_', true), $logger);
    }
}
