<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

final readonly class ThemeIr
{
    public function __construct(
        private array $metadata = [],
        private array $entities = [],
        private array $compositions = [],
        private array $queries = [],
        private array $workflows = [],
        private array $designSystems = [],
        private array $assets = [],
        private array $integrations = [],
    ) {
    }

    public function entities(): array
    {
        return $this->entities;
    }

    public function compositions(): array
    {
        return $this->compositions;
    }

    public function queries(): array
    {
        return $this->queries;
    }

    public function workflows(): array
    {
        return $this->workflows;
    }

    public function designSystems(): array
    {
        return $this->designSystems;
    }

    /**
     * @return array<string, array{
     *     type: string,
     *     entry: string,
     *     dependencies: array<int, string>
     * }>
     */
    public function assets(): array
    {
        return $this->assets;
    }

    public function integrations(): array
    {
        return $this->integrations;
    }

    /**
     * @return array{
     *     name: string,
     *     description: string,
     *     version: string,
     *     author: string,
     *     author_uri: string,
     *     theme_uri: string,
     *     text_domain: string,
     * }
     */
    public function metadata(): array
    {
        return $this->metadata;
    }
}
