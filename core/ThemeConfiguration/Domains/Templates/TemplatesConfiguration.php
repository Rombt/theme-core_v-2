<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Templates;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;

final readonly class TemplatesConfiguration implements ConfigurationDomainInterface
{
    /**
     * @param array<string, array<string, mixed>> $templates
     */
    public function __construct(
        private array $templates,
    ) {
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function templates(): array
    {
        return $this->templates;
    }
}
