<?php

declare(strict_types=1);

namespace Tests\Unit\Artifacts\Templates;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Artifacts\Templates\TemplateDiagnosticData;
use Rombt\ThemeCore\ThemeComponents\Domains\Rendering\Rendering;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\Resource;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\TemplateNode;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\ValueObjects\TemplateNodeType;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\ValueObjects\TemplateIdentity;

final class TemplateDiagnosticDataTest extends TestCase
{
    public function testTemplateIdentityIsRepresentedAsAString(): void
    {
        self::assertSame(
            'index',
            TemplateDiagnosticData::templateIdentity(new TemplateIdentity('index')),
        );
    }

    public function testNodeContainsOnlyItsIdentifierAndSlot(): void
    {
        $node = new TemplateNode(
            id: 'header',
            nodeId: null,
            compositionId: 'header-composition',
            type: new TemplateNodeType('section'),
            resource: new Resource('header-resource'),
            function: null,
            rendering: Rendering::Inline,
            slot: 2,
        );

        self::assertSame(
            [
                'id' => 'header',
                'slot' => 2,
            ],
            TemplateDiagnosticData::node($node),
        );
    }

    public function testNodeWithoutSlotKeepsNullSlot(): void
    {
        $node = new TemplateNode(
            id: 'content',
            nodeId: 'content-node',
            compositionId: null,
            type: new TemplateNodeType('container'),
            resource: null,
            function: null,
            rendering: Rendering::Inline,
            slot: null,
        );

        self::assertSame(
            [
                'id' => 'content',
                'slot' => null,
            ],
            TemplateDiagnosticData::node($node),
        );
    }
}
