<?php

declare(strict_types=1);

namespace Tests\Support\Definitions;

use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;
use Rombt\ThemeCore\Contracts\Logging\LoggerInterface;
use Rombt\ThemeCore\Contracts\Logging\LogWriterInterface;
use Rombt\ThemeCore\Contracts\Logging\LogFormatterInterface;

final class TestDefinitions
{
    public static function logger(): ServiceDefinition
    {
        return new ServiceDefinition(
            identifier: LoggerInterface::class,
            class: LoggerInterface::class,
            lifecycle: ServiceLifecycle::LAZY
        );
    }

    public static function logWriter(string $implementation): ServiceDefinition
    {
        return new ServiceDefinition(
            identifier: LogWriterInterface::class,
            class: $implementation,
            lifecycle: ServiceLifecycle::LAZY
        );
    }

    public static function logFormatter(string $implementation): ServiceDefinition
    {
        return new ServiceDefinition(
            identifier: LogFormatterInterface::class,
            class: $implementation,
            lifecycle: ServiceLifecycle::LAZY
        );
    }
}
