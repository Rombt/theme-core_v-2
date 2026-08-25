<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates\Contracts;

use Rombt\ThemeCore\Artifacts\Templates\TemplateMaterializationResult;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateNode;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\ValueObjects\TemplateIdentity;

interface TemplateNodeMaterializerInterface
{
    public function materialize(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): TemplateMaterializationResult;

    public function materializeTemplatePart(
        TemplateNode $node,
        TemplateIdentity $templateIdentity,
    ): TemplateMaterializationResult;
}
