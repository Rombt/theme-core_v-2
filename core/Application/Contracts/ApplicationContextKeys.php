<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Application\Contracts;

final class ApplicationContextKeys
{
    public const CONFIGURATION = 'configuration';

    public const ENVIRONMENT = 'environment';

    public const PROJECT_ROOT = 'project_root';

    public const APPLICATION_VERSION = 'application_version';

    public const CLOCK = 'clock';

    public const LOGGER = 'logger';

    private function __construct()
    {
    }
}
