<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Generators\Templates;

use RuntimeException;
use Rombt\ThemeCore\ThemeIr\Concepts\Templates\Template;

final class ClassicPhpTemplateDestinationResolver
{
    public function resolve(
        Template $template,
    ): string {
        return match ($template->purpose()->value()) {
            'header'   => 'header.php',
            'footer'   => 'footer.php',
            'sidebar'  => 'sidebar.php',

            'index'    => 'index.php',
            'single'   => 'single.php',
            'page'     => 'page.php',
            'archive'  => 'archive.php',
            'category' => 'category.php',
            'search'   => 'search.php',
            '404'      => '404.php',

            default => throw new RuntimeException(
                sprintf(
                    'Unknown template purpose "%s".',
                    $template->purpose()->value(),
                ),
            ),
        };
    }
}
