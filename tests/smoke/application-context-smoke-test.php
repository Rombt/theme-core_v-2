<?php

declare(strict_types=1);

use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Composition\Contracts\CompositionRuntimeInterface;

require dirname(__DIR__) . '/bootstrap.php';

$context = $app->getContext();

echo 'Has Context: ';
echo $app->hasContext() ? 'yes' : 'no';
echo PHP_EOL;

echo 'Has Composition Runtime: ';
echo $context->has(ApplicationContextKeys::COMPOSITION_RUNTIME) ? 'yes' : 'no';
echo PHP_EOL;

$runtime = $context->get(ApplicationContextKeys::COMPOSITION_RUNTIME);

echo 'Runtime Class: ';
echo get_class($runtime);
echo PHP_EOL;

echo 'Is CompositionRuntimeInterface: ';
echo $runtime instanceof CompositionRuntimeInterface
    ? 'yes'
    : 'no';

echo PHP_EOL;
