<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use Rombt\ThemeCore\ThemeIR\Domains\Templates\TemplateNode;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\ValueObjects\TemplateIdentity;

final class TemplateDiagnosticData
{
    public static function templateIdentity(
        TemplateIdentity $identity,
    ): string {
        return $identity->value();
    }

    /**
     * @return array{id: string, slot: ?int}
     */
    public static function node(
        TemplateNode $node,
    ): array {
        return [
            'id' => $node->id(),
            'slot' => $node->slot(),
        ];
    }
}
