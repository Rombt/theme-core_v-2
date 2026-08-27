<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Templates;

use InvalidArgumentException;

final class BlockTemplatePathResolver
{
    public function templateDestination(
        string $identity,
    ): string {
        return sprintf(
            'templates/%s.html',
            $this->filename($identity),
        );
    }

    public function templatePartDestination(
        string $resourceId,
    ): string {
        return sprintf(
            'parts/%s.html',
            $this->filename($resourceId),
        );
    }

    public function templatePartSlug(
        string $resourceId,
    ): string {
        return $this->filename($resourceId);
    }

    private function filename(
        string $value,
    ): string {
        $value = trim($value);

        if ($value === '') {
            throw new InvalidArgumentException(
                'Block template artifact name cannot be empty.',
            );
        }

        return str_replace('_', '-', $value);
    }
}
