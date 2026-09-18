<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Templates;

use Rombt\ThemeCore\ThemeIR\Domains\Templates\ValueObjects\TemplateIdentity;

final readonly class Template
{
    public function __construct(
        private TemplateIdentity $identity,
        private TemplateTree $tree,
    ) {
    }

    public function identity(): TemplateIdentity
    {
        return $this->identity;
    }

    public function tree(): TemplateTree
    {
        return $this->tree;
    }
}
