<?php

declare(strict_types=1);

use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;

$app = require dirname(__DIR__) . '/core/bootstrap/application.php';

$runtime = $app->getContext()->get(ApplicationContextKeys::COMPOSITION_RUNTIME);

echo '$app = ';
var_dump($app);

echo PHP_EOL;
echo '$runtime = ';
var_dump($runtime);
