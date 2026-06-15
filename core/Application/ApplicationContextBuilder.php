<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Application;

use Rombt\ThemeCore\Application\Contracts\ApplicationContextBuilderInterface;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextInterface;
use Rombt\ThemeCore\Application\Exceptions\ApplicationContextBuilderAlreadyFinalizedException;
use Rombt\ThemeCore\Application\Exceptions\ApplicationContextObjectAlreadyRegisteredException;
use Rombt\ThemeCore\Application\Exceptions\ApplicationContextObjectNotFoundException;

final class ApplicationContextBuilder implements ApplicationContextBuilderInterface
{
    /**
     * @var array<string, object>
     */
    private array $objects = [];

    private bool $built = false;

    public function register(string $key, object $value): void
    {
        if ($this->built) {
            throw new ApplicationContextBuilderAlreadyFinalizedException(
                'ApplicationContextBuilder is already finalized.'
            );
        }

        if (isset($this->objects[$key])) {
            throw new ApplicationContextObjectAlreadyRegisteredException(
                sprintf(
                    'ApplicationContext object "%s" is already registered.',
                    $key
                )
            );
        }

        $this->objects[$key] = $value;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->objects);
    }

    public function get(string $key): object
    {
        if (!$this->has($key)) {
            throw new ApplicationContextObjectNotFoundException(
                sprintf(
                    'ApplicationContext object "%s" is not registered.',
                    $key
                )
            );
        }

        return $this->objects[$key];
    }

    public function build(): ApplicationContextInterface
    {
        if ($this->built) {
            throw new ApplicationContextBuilderAlreadyFinalizedException(
                'ApplicationContextBuilder is already finalized.'
            );
        }

        $this->built = true;

        return new ApplicationContext($this->objects);
    }

    public function isBuilt(): bool
    {
        return $this->built;
    }
}
