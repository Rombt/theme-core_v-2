<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Concepts\Templates;

final readonly class TemplateTree
{
    /**
     * @param list<TemplateNode> $roots
     */
    public function __construct(
        private array $roots,
    ) {
    }

    /**
     * @return list<TemplateNode>
     */
    public function roots(): array
    {
        return $this->roots;
    }
}
