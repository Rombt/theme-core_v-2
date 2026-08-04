<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Domains\Templates;

use RuntimeException;
use Rombt\ThemeCore\ThemeComponents\ComponentId;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\Composition;
use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionsComponent;
use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\Template;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateCollection;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\TemplateTreeBuilder;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\ValueObjects\TemplateIdentity;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\ValueObjects\TemplatePurpose;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\ValueObjects\UserScenario;
use Rombt\ThemeCore\ThemeIr\Contracts\ThemeConceptInterface;
use Rombt\ThemeCore\ThemeIr\Contracts\ThemeIrResolverInterface;

final readonly class TemplatesThemeIrResolver implements ThemeIrResolverInterface
{
    public function __construct(
        private TemplateTreeBuilder $treeBuilder = new TemplateTreeBuilder(),
    ) {
    }

    public function resolve(
        ThemeComponentCollection $components,
    ): ThemeConceptInterface {
        $themeComponent = $components->find(
            new ComponentId('compositions'),
        );

        if ($themeComponent === null) {
            throw new RuntimeException(
                'Theme component "compositions" not found.',
            );
        }

        $component = $themeComponent->component();

        if (!$component instanceof CompositionsComponent) {
            throw new RuntimeException(
                'Theme component "compositions" must contain CompositionsComponent.',
            );
        }

        $templates = [];

        foreach ($component->compositions() as $composition) {
            if ($composition->isTemplatePart()) {
                continue;
            }

            $templates[] = $this->createTemplate($composition);
        }

        return new TemplatesThemeConcept(
            new TemplateCollection($templates),
        );
    }

    private function createTemplate(
        Composition $composition,
    ): Template {
        $root = $composition->nodes()->all()[0] ?? throw new RuntimeException(
            sprintf(
                'Template "%s" must contain a root node.',
                $composition->id(),
            ),
        );

        return new Template(
            identity: new TemplateIdentity($composition->id()),
            tree: $this->treeBuilder->build($root),
        );
    }
}
