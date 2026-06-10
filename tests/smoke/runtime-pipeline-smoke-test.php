<?php

declare(strict_types=1);

use Rombt\ThemeCore\Infrastructure\Diagnostics\DiagnosticsService;
use Rombt\ThemeCore\Runtime\ExecutionRuntime;
use Rombt\ThemeCore\Runtime\Pipeline\Pipeline;
use Rombt\ThemeCore\Runtime\Pipeline\PipelineExecutor;
use Rombt\ThemeCore\Runtime\Result\BuildResultFactory;
use Rombt\ThemeCore\Runtime\Session\BuildSessionFactory;
use Rombt\ThemeCore\Runtime\Stages\BuildThemeStage;
use Rombt\ThemeCore\Runtime\Stages\GenerateArtifactsStage;
use Rombt\ThemeCore\Runtime\Stages\LoadConfigurationStage;
use Rombt\ThemeCore\Runtime\Stages\WriteArtifactsStage;

require dirname(__DIR__) . '/bootstrap.php';

$diagnostics = new DiagnosticsService();

$pipeline = new Pipeline([
    new LoadConfigurationStage($diagnostics),
    new BuildThemeStage($diagnostics),
    new GenerateArtifactsStage($diagnostics),
    new WriteArtifactsStage($diagnostics),
]);

$runtime = new ExecutionRuntime(
    new BuildSessionFactory(),
    new BuildResultFactory(),
    new PipelineExecutor(),
    $logger
);

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
