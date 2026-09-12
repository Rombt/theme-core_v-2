<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Formatters;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Runtime\Contracts\ExternalProcessRunnerInterface;
use Rombt\ThemeCore\Runtime\Contracts\ThemeFormatterInterface;

final readonly class PrettierThemeFormatter implements ThemeFormatterInterface
{
    public function __construct(
        private ExternalProcessRunnerInterface $processRunner,
        private Application $app,
    ) {
    }

    /**
     * @param list<string> $themePaths
     */
    public function format(array $themePaths): void
    {

        $logger = $this->app->getContext()->get(ApplicationContextKeys::LOGGER);

        $projectRoot = $this->app->getContext()->get(ApplicationContextKeys::PROJECT_ROOT);

        $logger->dump('$projectRoot = ',);
        $logger->dump($projectRoot);

        foreach ($themePaths as $themePath) {
            $this->processRunner->run([
                'npx',
                'prettier',
                '--plugin=@prettier/plugin-php',
                '--config',
                'core/Runtime/Formatters/.prettierrc',
                '--write',
                $themePath,
            ]);
        }
    }
}
