<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

interface ThemeFormatterInterface
{
    /**
     * @param list<string> $themePaths
     */
    public function format(array $themePaths): void;
}
