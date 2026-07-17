<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIr\Contracts;

use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentCollectionInterface;

interface ThemeIrResolverInterface
{
    public function resolve(ThemeComponentCollectionInterface $components): mixed;
}
