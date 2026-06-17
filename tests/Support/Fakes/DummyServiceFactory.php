<?php

declare(strict_types=1);

namespace Tests\Support\Fakes;

use Rombt\ThemeCore\Composition\Contracts\ServiceFactoryInterface;

final class DummyServiceFactory implements ServiceFactoryInterface
{
    public function create(string $class, array $dependencies = []): object
    {
        return new $class(...$dependencies);
    }
}
