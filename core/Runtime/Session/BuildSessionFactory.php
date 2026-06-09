<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

use Rombt\ThemeCore\Runtime\Contracts\BuildSessionFactoryInterface;

final class BuildSessionFactory implements BuildSessionFactoryInterface
{
    public function create(): BuildSession
    {
        return new BuildSession(
            uniqid('session_', true)
        );
    }
}
