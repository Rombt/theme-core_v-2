<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators\Templates;

use Rombt\ThemeCore\ThemeIr\Concepts\Templates\Template;

final readonly class ClassicPhpTemplateRenderer
{
    public function __construct(
        private TemplateTreeRenderer $treeRenderer,
    ) {
    }

    public function render(Template $template): string
    {
        //todo
        // здесь впоследствии появится логика, относящаяся к шаблону целиком, а не к дереву .
        // Например:
        // добавление служебных комментариев в начало файла;
        // обработка особенностей отдельных шаблонов(index, single, 404 и т . д . );
        // подключение обязательных конструкций для классической темы;
        // финальная постобработка результата перед передачей в Materialization .
        // TemplateTreeRenderer при этом останется универсальным и ничего об этом знать не будет .


        return $this->treeRenderer->render(
            $template->tree(),
        );
    }
}
