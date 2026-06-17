<?php

declare(strict_types=1);

namespace Tests\Integration\Composition;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Composition\Providers\CoreServiceDefinitionProvider;
use Rombt\ThemeCore\Composition\Definitions\ServiceDefinition;

final class ServiceDefinitionProviderTest extends TestCase
{
    public function testProviderReturnsValidServiceDefinitions(): void
    {
        $provider = new CoreServiceDefinitionProvider();

        $definitions = $provider->provide();

        self::assertNotEmpty($definitions);

        foreach ($definitions as $definition) {
            self::assertInstanceOf(
                ServiceDefinition::class,
                $definition
            );

            self::assertNotEmpty($definition->getIdentifier());
            self::assertNotEmpty($definition->getClass());
            self::assertNotEmpty($definition->getLifecycle());
        }
    }


    public function testProviderDefinitionsAreInternallyConsistent(): void
    {
        $provider = new CoreServiceDefinitionProvider();

        $definitions = $provider->provide();

        foreach ($definitions as $definition) {
            self::assertTrue(
                class_exists($definition->getClass())
            );

            self::assertTrue(
                in_array(
                    $definition->getLifecycle(),
                    [
                    'eager',
                    'lazy',
                    'transient',
                    ],
                    true
                )
            );
        }
    }
}
