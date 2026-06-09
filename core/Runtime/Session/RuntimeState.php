<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Session;

final class RuntimeState
{
    public const CREATED = 'created';

    public const RUNNING = 'running';

    public const FAILED = 'failed';

    public const COMPLETED = 'completed';

    public const CANCELLED = 'cancelled';

    public static function isValid(string $state): bool
    {
        return in_array(
            $state,
            [
                self::CREATED,
                self::RUNNING,
                self::FAILED,
                self::COMPLETED,
                self::CANCELLED,
            ],
            true
        );
    }

    private function __construct()
    {
    }
}
