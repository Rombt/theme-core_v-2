<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateNodeMaterializerInterface;
use Rombt\ThemeCore\Artifacts\Templates\Contracts\TemplateTreeMaterializerInterface;
use Rombt\ThemeCore\ThemeIR\Domains\Templates\Template;
use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;

final readonly class ClassicTemplateTreeMaterializer implements TemplateTreeMaterializerInterface
{
    private LoggerInterface $logger;

    public function __construct(
        private TemplateNodeMaterializerInterface $nodeMaterializer,
        Application $app,
    ) {

        $this->logger = $app->getContext()->get(ApplicationContextKeys::LOGGER);
    }

    public function materialize(Template $template): TemplateMaterializationResult
    {
        $contents = [];

        foreach ($template->tree()->roots() as $root) {
            $result = $this->nodeMaterializer->materializeTemplatePart(
                $root,
                $template->identity(),
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
    private function joinContents(array $contents): string
    {
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
