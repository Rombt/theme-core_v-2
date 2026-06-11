<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Application;

use LogicException;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextBuilderInterface;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextInterface;

final class ApplicationContextBuilder implements ApplicationContextBuilderInterface
{
    /**
     * @var array<string, object>
     */
    private array $objects = [];

    public function register(
        string $key,
        object $value
    ): void {
        if (isset($this->objects[$key])) {
            throw new LogicException(
                sprintf(
                    'ApplicationContext object "%s" is already registered.',
                    $key
                )
            );
        }

        $this->objects[$key] = $value;
    }

    public function build(): ApplicationContextInterface
    {
        return new ApplicationContext(
            $this->objects
        );
    }
}
