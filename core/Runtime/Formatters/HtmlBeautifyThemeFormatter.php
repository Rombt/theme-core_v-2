<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Formatters;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Runtime\Contracts\ExternalProcessRunnerInterface;
use Rombt\ThemeCore\Runtime\Contracts\ThemeFormatterInterface;

final readonly class HtmlBeautifyThemeFormatter implements ThemeFormatterInterface
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
        $projectRoot = $this->app
            ->getContext()
            ->get(ApplicationContextKeys::PROJECT_ROOT);

        $projectRootPath = $projectRoot->value();

        $htmlBeautifyPath = $projectRootPath
            . DIRECTORY_SEPARATOR . 'node_modules'
            . DIRECTORY_SEPARATOR . '.bin'
            . DIRECTORY_SEPARATOR . 'html-beautify.cmd';

        foreach ($themePaths as $themePath) {
            $phpFiles = $this->findPhpFiles($themePath);

            foreach ($phpFiles as $phpFile) {
                $this->processRunner->run(
                    array(
                        $htmlBeautifyPath,
                        '--templating=php',
                        '-o',
                        $phpFile,
                        $phpFile,
                    )
                );
            }
        }
    }

    /**
     * @return list<string>
     */
    private function findPhpFiles(string $themePath): array
    {
        $files = array();

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $themePath,
                \FilesystemIterator::SKIP_DOTS,
            ),
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }
}
