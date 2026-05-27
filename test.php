<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Bootstrap\Kernel;

$app = new Application();

$kernel = new Kernel($app);

var_dump($kernel->isBootstrapped());

$kernel->bootstrap();

var_dump($kernel->isBootstrapped());