<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Bootstrappers;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Bootstrap\Kernel;
use Rombt\ThemeCore\Configuration\Configuration;
use Rombt\ThemeCore\Infrastructure\Logging\Formatters\JsonFormatter;
use Rombt\ThemeCore\Infrastructure\Logging\PrettyObjectDumper;
use Rombt\ThemeCore\Infrastructure\Logging\StructuredLogger;
use Rombt\ThemeCore\Infrastructure\Logging\Writers\FilesystemWriter;

final class CreateLoggerBootstrapper implements PrioritizedBootstrapperInterface
{
    public static function priority(): int
    {
        return 84;
    }

    public function bootstrap(Application $app, Kernel $kernel): void
    {
        /** @var Configuration $configuration */
        $configuration = $app->getContextBuilder()->get(
            ApplicationContextKeys::CONFIGURATION
        );

        /** @var string $logging_file_path */
        $logging_file_path = $configuration->get('logging.runtime_path');
        $debug_file_path = $configuration->get('logging.debug_path');

        $formatter = new JsonFormatter();

        $writer = new FilesystemWriter(
            $logging_file_path,
            $configuration->get('logging.runtime_append')
        );

        $dumper = new PrettyObjectDumper();

        $dumpWriter = new FilesystemWriter(
            $debug_file_path,
            $configuration->get('logging.debug_append')
        );

        $logger = new StructuredLogger(
            $formatter,
            $writer,
            $dumper,
            $dumpWriter,
        );

        $builder = $app->getContextBuilder();

        $builder->register(
            ApplicationContextKeys::LOG_FORMATTER,
            $formatter,
        );

        $builder->register(
            ApplicationContextKeys::LOG_WRITER,
            $writer,
        );

        $builder->register(
            ApplicationContextKeys::LOGGER,
            $logger,
        );
    }
}
