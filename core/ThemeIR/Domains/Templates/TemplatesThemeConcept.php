<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Domains\Templates;

use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateCollection;
use Rombt\ThemeCore\ThemeIr\IrId;
use Rombt\ThemeCore\ThemeIr\ThemeConcept;

final readonly class TemplatesThemeConcept extends ThemeConcept
{
    public function __construct(private TemplateCollection $templates)
    {
        parent::__construct(new IrId('templates'));
    }

    public function templates(): TemplateCollection
    {
        return $this->templates;
    }
}
