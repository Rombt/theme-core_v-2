<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Result\StageResult;

interface StageInterface
{
    public function execute(
        ExecutionContext $context
    ): StageResult;
}
