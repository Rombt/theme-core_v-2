<?php

declare(strict_types=1);

namespace Tests\Integration\Application;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Application\Application;

final class ApplicationBootstrapTest extends TestCase
{
    public function testApplicationCanBootstrap(): void
    {
        $app = require dirname(__DIR__, 3) . '/core/Bootstrap/application.php';

        $this->assertInstanceOf(Application::class, $app);

        $context = $app->getContext();

        $this->assertInstanceOf(
            \Rombt\ThemeCore\Application\Contracts\ApplicationContextInterface::class,
            $context
        );
    }
}
