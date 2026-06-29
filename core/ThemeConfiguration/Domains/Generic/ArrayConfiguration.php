<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Generic;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;

final readonly class ArrayConfiguration implements ConfigurationDomainInterface
{
    public function __construct(
        private array $data,
    ) {
    }

    public function data(): array
    {
        return $this->data;
    }
}
