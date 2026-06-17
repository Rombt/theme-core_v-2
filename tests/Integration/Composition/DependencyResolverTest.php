<?php

declare(strict_types=1);

namespace Tests\Integration\Composition;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Composition\Graph\DependencyGraph;
use Rombt\ThemeCore\Composition\Graph\DependencyNode;
use Rombt\ThemeCore\Composition\Resolution\DependencyResolver;

final class DependencyResolverTest extends TestCase
{
    public function testDependencyResolverReturnsNodeDependencies(): void
    {
        $graph = new DependencyGraph([
            'logger' => new DependencyNode(
                'logger',
                [
                    'formatter',
                    'writer',
                ]
            ),

            'formatter' => new DependencyNode(
                'formatter',
                []
            ),

            'writer' => new DependencyNode(
                'writer',
                []
            ),
        ]);

        $resolver = new DependencyResolver($graph);

        $result = $resolver->resolve('logger');

        self::assertSame(
            ['formatter', 'writer'],
            $result
        );
    }

    public function testDependencyResolverReturnsEmptyArrayForLeafNode(): void
    {
        $graph = new DependencyGraph([
            'formatter' => new DependencyNode(
                'formatter',
                []
            ),
        ]);

        $resolver = new DependencyResolver($graph);

        self::assertSame(
            [],
            $resolver->resolve('formatter')
        );
    }
}
