<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateNodeMaterializerInterface;
use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateTreeMaterializerInterface;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\Template;

final readonly class BlockTemplateTreeMaterializer implements TemplateTreeMaterializerInterface
{
    public function __construct(
        private TemplateNodeMaterializerInterface $nodeMaterializer,
    ) {
    }

    public function materialize(
        Template $template,
    ): TemplateMaterializationResult {
        $contents = [];

        foreach ($template->tree()->roots() as $root) {
            $content = $this->nodeMaterializer
                ->materialize(
                    $root,
                    $template->identity(),
                    true,
                )
                ->content();

            if ($content === '') {
                continue;
            }

            $contents[] = $content;
        }

        return new TemplateMaterializationResult(
            implode(PHP_EOL, $contents),
        );
    }
}
