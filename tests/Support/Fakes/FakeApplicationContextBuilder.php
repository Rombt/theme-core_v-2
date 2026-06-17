<?php

declare(strict_types=1);

namespace Tests\Support\Fakes;

use LogicException;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextBuilderInterface;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextInterface;
use Rombt\ThemeCore\Application\ApplicationContext;

final class FakeApplicationContextBuilder implements ApplicationContextBuilderInterface
{
    /**
     * @var array<string, object>
     */
    private array $entries = [];

    private bool $built = false;

    public function register(
        string $key,
        object $value
    ): void {
        $this->entries[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($this->entries[$key]);
    }

    public function get(string $key): object
    {
        if (!$this->has($key)) {
            throw new LogicException(
                sprintf(
                    'Context entry "%s" not found.',
                    $key
                )
            );
        }

        return $this->entries[$key];
    }

    public function build(): ApplicationContextInterface
    {
        $this->built = true;

        return new ApplicationContext($this->entries);
    }

    public function isBuilt(): bool
    {
        return $this->built;
    }
}
