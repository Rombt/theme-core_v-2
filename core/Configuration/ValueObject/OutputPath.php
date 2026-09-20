<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Configuration\ValueObject;

use InvalidArgumentException;

final class OutputPath
{
    private const TYPE_RELATIVE = 'relative';
    private const TYPE_ABSOLUTE = 'absolute';
    private const TYPE_BASE = 'base';

    private function __construct(
        private readonly string $type,
        private readonly string $path,
        private readonly ?string $base,
    ) {
    }

    public static function relative(string $path): self
    {
        return new self(
            self::TYPE_RELATIVE,
            $path,
            null,
        );
    }

    public static function absolute(string $path): self
    {
        return new self(
            self::TYPE_ABSOLUTE,
            $path,
            null,
        );
    }

    public static function base(
        string $base,
        string $path,
    ): self {
        if ($base === '') {
            throw new InvalidArgumentException(
                'Output path base must not be empty.'
            );
        }

        return new self(
            self::TYPE_BASE,
            $path,
            $base,
        );
    }

    public function resolve(
        string $projectRoot,
        array $bases = [],
    ): string {
        return match ($this->type) {
            self::TYPE_RELATIVE => $this->join(
                $projectRoot,
                $this->path,
            ),

            self::TYPE_ABSOLUTE => $this->path,

            self::TYPE_BASE => $this->resolveBase(
                $projectRoot,
                $bases,
            ),

            default => throw new InvalidArgumentException(
                sprintf(
                    'Unsupported output path type [%s].',
                    $this->type,
                )
            ),
        };
    }

    private function resolveBase(
        string $projectRoot,
        array $bases,
    ): string {
        if ($this->base === null) {
            throw new InvalidArgumentException(
                'Output path base is not defined.'
            );
        }

        if (!array_key_exists($this->base, $bases)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Output path base [%s] is not defined.',
                    $this->base,
                )
            );
        }

        $basePath = $bases[$this->base];

        if (!is_string($basePath)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Output path base [%s] must be string.',
                    $this->base,
                )
            );
        }

        if (!$this->isAbsolute($basePath)) {
            $basePath = $this->join(
                $projectRoot,
                $basePath,
            );
        }

        return $this->join(
            $basePath,
            $this->path,
        );
    }

    private function join(
        string $base,
        string $path,
    ): string {
        return rtrim($base, '/\\')
            . DIRECTORY_SEPARATOR
            . ltrim($path, '/\\');
    }

    private function isAbsolute(string $path): bool
    {
        return str_starts_with($path, '/')
            || str_starts_with($path, '\\')
            || preg_match('/^[A-Za-z]:[\/\\\\]/', $path) === 1;
    }
}
