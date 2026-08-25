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
            $result = $this->nodeMaterializer->materialize(
                $root,
                $template->identity(),
                true,
            );

            if ($result->content() === '') {
                continue;
            }

            $contents[] = $result->content();
        }

        return new TemplateMaterializationResult(
            $this->joinContents($contents),
        );
    }

    /**
     * @param array<int, string> $contents
     */
    private function joinContents(
        array $contents,
    ): string {
        $contents = array_values(
            array_filter(
                $contents,
                static fn (string $content): bool => $content !== '',
            ),
        );

        return implode(
            "\n\n",
            $contents,
        );
    }
}
