<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Templates;

use Rombt\ThemeCore\ThemeIR\FunctionDefinition;

final readonly class NodeFunctionDefinitionCollection
{
    /**
     * @param array<string, FunctionDefinition> $definitions
     */
    public function __construct(
        private array $definitions = [],
    ) {
    }

    public function find(string $nodeId): ?FunctionDefinition
    {
        return $this->definitions[$nodeId] ?? null;
    }
}
