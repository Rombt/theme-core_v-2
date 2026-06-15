<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;
use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;

final class BuildSessionFactory implements BuildSessionFactoryInterface
{
    public function create(
        LoggerInterface $logger,
    ): BuildSession {
        return new BuildSession(
            uniqid('session_', true),
            $logger,
        );
    }
}
