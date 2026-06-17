<?php

declare(strict_types=1);

namespace Tests\Integration\Composition;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Composition\Graph\DependencyGraphBuilder;
use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;
use Rombt\ThemeCore\Composition\Definitions\ServiceLifecycle;
use Rombt\ThemeCore\Composition\Registry\ServiceRegistry;

final class DependencyGraphBuilderTest extends TestCase
{
    public function testGraphIsBuiltFromRegistry(): void
    {
        $registry = new ServiceRegistry();

        $registry->register(
            new ServiceDefinition(
                identifier: 'logger',
                class: \stdClass::class,
                lifecycle: ServiceLifecycle::LAZY,
                dependencies: ['formatter']
            )
        );

        $registry->register(
            new ServiceDefinition(
                identifier: 'formatter',
                class: \stdClass::class,
                lifecycle: ServiceLifecycle::LAZY,
                dependencies: []
            )
        );

        $builder = new DependencyGraphBuilder();

        $graph = $builder->build($registry);

        self::assertTrue($graph->has('logger'));
        self::assertTrue($graph->has('formatter'));

        self::assertSame(
            ['formatter'],
            $graph->get('logger')->getDependencies()
        );
    }
    public function testMissingDependencyThrowsException(): void
    {
        $this->expectException(
            \Rombt\ThemeCore\Composition\Exceptions\CompositionDefinitionNotFoundException::class
        );

        $registry = new ServiceRegistry();

        $registry->register(
            new ServiceDefinition(
                identifier: 'logger',
                class: \stdClass::class,
                lifecycle: ServiceLifecycle::LAZY,
                dependencies: ['missing_service']
            )
        );

        $builder = new DependencyGraphBuilder();

        $builder->build($registry);
    }
}
