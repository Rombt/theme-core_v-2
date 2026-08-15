<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

interface TemplateResourceContentReaderInterface
{
    public function read(string $path): string;
}
