<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\SessionKeys;
use Rombt\ThemeCore\ThemeComponents\Contracts\ThemeComponentCollectionBuilderInterface;

final class BuildThemeComponentsStage implements StageInterface
{
    public function __construct(
        private readonly ThemeComponentCollectionBuilderInterface $builder,
    ) {
    }

    public function execute(ExecutionContext $context, Application $app): StageResult
    {
        try {
            $components = $this->builder->build($context->session()->package());
            $context->session()->setResource(SessionKeys::THEME_COMPONENTS, $components);

            echo '$context->session() = ';
            print_r($context->session());
            echo PHP_EOL;


            return new StageResult(
                success: true,
            );
        } catch (Throwable $e) {
            return new StageResult(
                success: false,
                error: $e,
            );
        }
    }
}
