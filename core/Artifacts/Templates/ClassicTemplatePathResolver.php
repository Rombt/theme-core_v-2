<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use InvalidArgumentException;

final class ClassicTemplatePathResolver
{
    /**
     * @var array<string, string>
     */
    private const TYPE_DIRECTORIES = [
        'layout' => 'template-parts/layout',
        'post' => 'template-parts/post',
        'page' => 'template-parts/page',
        'product' => 'template-parts/product',
        'navigation' => 'template-parts/navigation',
        'form' => 'template-parts/forms',
        'common' => 'template-parts/common',
    ];

    /**
     * @var array<string, string>
     */
    private const SPECIAL_DESTINATIONS = [
        'header' => 'header.php',
        'footer' => 'footer.php',
        'sidebar' => 'sidebar.php',
    ];

    public function templateDestination(
        string $identity,
    ): string {
        return self::SPECIAL_DESTINATIONS[$identity]
            ?? sprintf('%s.php', $identity);
    }

    public function templatePartDestination(
        string $type,
        string $resourceId,
    ): string {
        return sprintf(
            '%s/%s',
            $this->directory($type),
            $this->filename($resourceId),
        );
    }

    public function templatePartSlug(
        string $type,
        string $resourceId,
    ): string {
        return sprintf(
            '%s/%s',
            $this->slugDirectory($type),
            $this->filenameWithoutExtension($resourceId),
        );
    }

    public function directory(string $type): string
    {
        if (!isset(self::TYPE_DIRECTORIES[$type])) {
            throw new InvalidArgumentException(
                sprintf(
                    'Unknown Classic template-part type "%s".',
                    $type,
                ),
            );
        }

        return self::TYPE_DIRECTORIES[$type];
    }

    private function slugDirectory(string $type): string
    {
        return str_replace(
            'template-parts/',
            '',
            $this->directory($type),
        );
    }

    private function filename(string $resourceId): string
    {
        return $this->filenameWithoutExtension($resourceId) . '.php';
    }

    private function filenameWithoutExtension(
        string $resourceId,
    ): string {
        return str_replace('_', '-', $resourceId);
    }
}
