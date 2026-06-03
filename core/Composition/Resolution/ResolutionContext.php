<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Composition\Resolution;

final class ResolutionContext
{
    /**
     * @var array<string, object>
     */
    private array $instances = [];

    /**
     * @var string[]
     */
    private array $resolvingStack = [];


    public function hasInstance(string $identifier): bool
    {
        return isset($this->instances[$identifier]);
    }

    public function getInstance(string $identifier): object
    {
        return $this->instances[$identifier];
    }

    public function storeInstance(
        string $identifier,
        object $instance
    ): void {
        $this->instances[$identifier] = $instance;
    }


    public function push(string $identifier): void
    {
        $this->resolvingStack[] = $identifier;
    }

    public function pop(): void
    {
        array_pop($this->resolvingStack);
    }

    public function isResolving(string $identifier): bool
    {
        return in_array(
            $identifier,
            $this->resolvingStack,
            true
        );
    }
}
