<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Concepts\Templates;

use Rombt\ThemeCore\ThemeIr\Concepts\Templates\ValueObjects\TemplateIdentity;

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
