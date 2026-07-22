<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes;

final readonly class ResourceType
{
    private function __construct(private string $value)
    {
    }

    public static function unknown(): self
    {
        return new self('unknown');
    }

    public static function template(): self
    {
        return new self('template');
    }

    public static function style(): self
    {
        return new self('style');
    }

    public static function script(): self
    {
        return new self('script');
    }

    public static function image(): self
    {
        return new self('image');
    }

    public static function icon(): self
    {
        return new self('icon');
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $type): bool
    {
        return $this->value === $type->value;
    }
}
