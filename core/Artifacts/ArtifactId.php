<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

use InvalidArgumentException;

final readonly class ArtifactId
{
    public function __construct(
        private string $value
    ) {
        $value = trim($value);

        if ($value === '') {
            throw new InvalidArgumentException(
                'Artifact ID cannot be empty.'
            );
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
