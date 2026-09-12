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
        $configPath = $projectRoot->value()
        . DIRECTORY_SEPARATOR . 'core'
        . DIRECTORY_SEPARATOR . 'Runtime'
        . DIRECTORY_SEPARATOR . 'Formatters'
        . DIRECTORY_SEPARATOR . '.prettierrc';

        $logger->dump('$projectRoot = ');
        $logger->dump($projectRoot);
        $logger->dump('$configPath = ');
        $logger->dump($configPath);

        foreach ($themePaths as $themePath) {
            $this->processRunner->run([
                'npx',
                'prettier',
                '--plugin=@prettier/plugin-php',
                '--parser=php',
                '--config',
                $configPath,
                '--write',
                $themePath,
            ]);
        }
    }
}
