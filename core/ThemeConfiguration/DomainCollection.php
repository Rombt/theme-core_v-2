<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

final readonly class DomainCollection
{
    /**
     * @var array<string, ConfigurationDomain>
     */
    private array $domains;

    /**
     * @param iterable<ConfigurationDomain> $domains
     */
    public function __construct(iterable $domains = [])
    {
        $indexed = [];

        foreach ($domains as $domain) {
            $indexed[$domain->id()->value()] = $domain;
        }

        $this->domains = $indexed;
    }

    public function has(DomainId $id): bool
    {
        return isset($this->domains[$id->value()]);
    }

    public function get(DomainId $id): ConfigurationDomain
    {
        $domain = $this->domains[$id->value()] ?? null;

        if ($domain === null) {
            throw new \RuntimeException(
                sprintf('Domain "%s" is not registered.', $id->value())
            );
        }

        return $domain;
    }

    /**
     * @return iterable<ConfigurationDomain>
     */
    public function all(): iterable
    {
        foreach ($this->domains as $domain) {
            yield $domain;
        }
    }
}
