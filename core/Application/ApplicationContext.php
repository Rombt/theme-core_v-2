<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Application;

use Rombt\ThemeCore\Application\Contracts\ApplicationContextInterface;
use Rombt\ThemeCore\Application\Exceptions\ApplicationContextObjectNotFoundException;

final readonly class ApplicationContext implements ApplicationContextInterface
{
    /**
     * @param array<string, object> $objects
     */
    public function __construct(
        private array $objects
    ) {
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

    /**
     * @return array<string, object>
     */
    public function all(): array
    {
        return $this->objects;
    }
}
