<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Application;

use RuntimeException;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextInterface;

final class ApplicationContext implements ApplicationContextInterface
{
    /**
     * @var array<string, object>
     */
    private array $objects;

    /**
     * @param array<string, object> $objects
     */
    public function __construct(array $objects)
    {
        $this->objects = $objects;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->objects);
    }

    public function get(string $key): object
    {
        if (!$this->has($key)) {
            throw new RuntimeException(
                sprintf(
                    'ApplicationContext object "%s" is not registered.',
                    $key
                )
            );
        }

        return $this->objects[$key];
    }
}
