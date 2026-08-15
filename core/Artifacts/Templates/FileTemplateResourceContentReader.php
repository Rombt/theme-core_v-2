<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use RuntimeException;

final readonly class FileTemplateResourceContentReader implements TemplateResourceContentReaderInterface
{
    public function read(string $path): string
    {
        $content = file_get_contents($path);
        if ($content === false) {
            throw new RuntimeException(sprintf('Unable to read template resource "%s".', $path,),);
        } return $content;
    }
}
