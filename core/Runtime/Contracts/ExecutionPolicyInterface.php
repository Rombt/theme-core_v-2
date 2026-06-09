<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Contracts;

use Throwable;
use Rombt\ThemeCore\Runtime\Session\BuildSession;

interface ExecutionPolicyInterface
{
    /**
     * Обработать ошибку выполнения Pipeline
     */
    public function handle(Throwable $error, BuildSession $session): void;

    /**
     * Должен ли Runtime продолжать выполнение после ошибки
     */
    public function shouldContinue(Throwable $error): bool;
}
