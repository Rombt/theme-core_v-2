<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Templates;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\IrExportableInterface;

final readonly class TemplatesConfiguration implements
    ConfigurationDomainInterface
{
    private TemplateCollection $templates;

    /**
     * @param array<string, array<string, mixed>> $templates
     */
    public function __construct(array $templates)
    {
        $collection = [];

        foreach ($templates as $id => $template) {
            $collection[] = new Template(
                id: $id,
                composition: (string) ($template['composition'] ?? ''),
            );
        }

        $this->templates = new TemplateCollection($collection);
    }

    public function templates(): TemplateCollection
    {
        return $this->templates;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function toArray(): array
    {
        $result = [];

        foreach ($this->templates as $template) {
            $result[$template->id()] = [
                'composition' => $template->composition(),
            ];
        }

        return $result;
    }
}
