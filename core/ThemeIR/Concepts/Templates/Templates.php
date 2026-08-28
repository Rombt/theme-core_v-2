<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Concepts\Templates;

use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeConcept;

final readonly class Templates extends ThemeConcept implements TemplatesInterface
{
    public function __construct(
        IrId $id,
        private TemplateCollection $templates,
    ) {
        parent::__construct($id);
    }

    public function templates(): TemplateCollection
    {
        return $this->templates;
    }
}
