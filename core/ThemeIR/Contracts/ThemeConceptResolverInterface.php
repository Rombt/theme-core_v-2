<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Contracts;

use Rombt\ThemeCore\ThemeComponents\ThemeComponentCollection;

interface ThemeConceptResolverInterface
{
    public function resolve(
        ThemeComponentCollection $components,
    ): ThemeConceptInterface;
}
