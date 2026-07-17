<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Templates;

use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentInterface;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Templates\TemplateCollection;

final readonly class TemplatesComponent implements ThemeComponentInterface
{
    public function __construct(
        private TemplateCollection $templates,
    ) {
    }

    public function templates(): TemplateCollection
    {
        return $this->templates;
    }
}
