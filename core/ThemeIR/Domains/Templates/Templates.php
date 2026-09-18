<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Templates;

use Rombt\ThemeCore\ThemeIR\Contracts\FunctionComponentInterface;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeConcept;
use Rombt\ThemeCore\ThemeIR\FunctionDefinition;

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

    /**
     * @return list<FunctionComponentInterface>
     */
    public function functionComponents(): array
    {
        $components = [];

        foreach ($this->templates as $template) {
            $this->collectFunctionComponents(
                $template->tree()->roots(),
                $components,
            );
        }

        return $components;
    }

    /**
     * @param list<TemplateNode> $nodes
     * @param list<FunctionComponentInterface> $components
     */
    private function collectFunctionComponents(
        array $nodes,
        array &$components,
    ): void {
        foreach ($nodes as $node) {
            if ($node->function() !== null) {
                $function = $node->function();

                $components[] = new class ($function) implements FunctionComponentInterface {
                    public function __construct(
                        private readonly FunctionDefinition $function,
                    ) {
                    }

                    public function function(): ?FunctionDefinition
                    {
                        return $this->function;
                    }
                };
            }

            $this->collectFunctionComponents(
                $node->children(),
                $components,
            );
        }
    }
}
