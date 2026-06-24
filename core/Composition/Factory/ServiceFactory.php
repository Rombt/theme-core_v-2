<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Factory;

use Rombt\ThemeCore\Composition\Contracts\ServiceFactoryInterface;
use Throwable;
use Rombt\ThemeCore\Composition\Exceptions\CompositionInstantiationException;

final class ServiceFactory implements ServiceFactoryInterface
{
    public function create(string $class, array $dependencies = []): object
    {
        try {
            return new $class(...$dependencies);
        } catch (Throwable $exception) {
            throw new CompositionInstantiationException(
                sprintf(
                    'Failed to instantiate service [%s].',
                    $class
                ),
                previous: $exception
            );
        }
    }
}
