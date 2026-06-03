<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Factory;

use Rombt\ThemeCore\Composition\Contracts\ServiceFactoryInterface;

final class ServiceFactory implements ServiceFactoryInterface
{
    public function create(
        string $class,
        array $dependencies = []
    ): object {
        return new $class(...$dependencies);
    }
}
