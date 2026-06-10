<?php

declare(strict_types=1);

use Rombt\ThemeCore\Composition\Contracts\CompositionRuntimeInterface;
use Rombt\ThemeCore\Runtime\ExecutionRuntime;

require dirname(__DIR__) . '/bootstrap.php';

/** @var CompositionRuntimeInterface $runtime */
$runtime = $app->get('composition.runtime');

$executionRuntime = $runtime
    ->services()
    ->get(ExecutionRuntime::class);

echo get_class($executionRuntime);
echo PHP_EOL;
