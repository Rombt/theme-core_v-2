<?php

declare(strict_types=1);

use Rombt\ThemeCore\Runtime\ExecutionRuntime;
use Rombt\ThemeCore\Runtime\Pipeline\Pipeline;
use Rombt\ThemeCore\Runtime\Pipeline\PipelineExecutor;
use Rombt\ThemeCore\Runtime\Result\BuildResultFactory;
use Rombt\ThemeCore\Runtime\Session\BuildSessionFactory;
use Rombt\ThemeCore\Runtime\Stages\TestStage;

require dirname(__DIR__) . '/bootstrap.php';

$runtime = new ExecutionRuntime(
    new BuildSessionFactory(),
    new BuildResultFactory(),
    new PipelineExecutor(),
    $logger
);

$pipeline = new Pipeline([
    new TestStage(),
]);

$result = $runtime->run($pipeline);

echo PHP_EOL;

echo 'Build Status: ';
echo $result->getStatus();
echo PHP_EOL;

if ($result->getError() !== null) {
    echo 'Error: ';
    echo $result->getError()->getMessage();
    echo PHP_EOL;
}

echo PHP_EOL;
