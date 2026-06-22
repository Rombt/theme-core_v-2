<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

final readonly class ThemeMetadata
{
    public function __construct(
        private string $name,
        private string $description = '',
        private string $version = '',
        private string $author = '',
        private string $authorUri = '',
        private string $themeUri = '',
        private string $textDomain = '',
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function version(): string
    {
        return $this->version;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function authorUri(): string
    {
        return $this->authorUri;
    }

    public function themeUri(): string
    {
        return $this->themeUri;
    }

    public function textDomain(): string
    {
        return $this->textDomain;
    }
}
