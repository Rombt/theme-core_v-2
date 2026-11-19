<?php

declare(strict_types=1);

namespace Tests\Unit\ThemeConfiguration\Domains\Nodes;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;
use Rombt\ThemeCore\ThemeConfiguration\DomainId;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\NodesConfiguration;
use Rombt\ThemeCore\ThemeConfiguration\Domains\Nodes\NodesValidator;

final class NodesValidatorTest extends TestCase
{
    public function testAcceptsNodeWithoutFunctionDefinition(): void
    {
        self::expectNotToPerformAssertions();

        $this->validate([
            'header' => ['type' => 'template', 'name' => 'Header'],
        ]);
    }

    #[DataProvider('validFunctionOrders')]
    public function testAcceptsFunctionOrderWithinRange(int $order): void
    {
        self::expectNotToPerformAssertions();

        $this->validate([
            'header' => [
                'type' => 'template',
                'name' => 'Header',
                'function' => ['enabled' => true, 'order' => $order],
            ],
        ]);
    }

    public static function validFunctionOrders(): iterable
    {
        yield 'minimum' => [0];
        yield 'maximum' => [100];
    }

    #[DataProvider('invalidFunctionOrders')]
    public function testRejectsFunctionOrderOutsideRange(int $order): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Function order for node "header" must be between 0 and 100.');

        $this->validate([
            'header' => [
                'type' => 'template',
                'name' => 'Header',
                'function' => ['enabled' => true, 'order' => $order],
            ],
        ]);
    }

    public static function invalidFunctionOrders(): iterable
    {
        yield 'below minimum' => [-1];
        yield 'above maximum' => [101];
    }

    public function testRejectsEmptyNodeId(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Node ID must not be empty.');

        $this->validate([
            '' => ['type' => 'template', 'name' => 'Header'],
        ]);
    }

    public function testSerializesFunctionDefinition(): void
    {
        $configuration = new NodesConfiguration([
            'header' => [
                'type' => 'template',
                'name' => 'Header',
                'function' => ['enabled' => true, 'order' => 25],
            ],
        ]);

        self::assertSame(
            ['enabled' => true, 'order' => 25],
            $configuration->toArray()['header']['function'],
        );
    }

    /**
     * @param array<string, array<string, mixed>> $nodes
     */
    private function validate(array $nodes): void
    {
        $configuration = new NodesConfiguration($nodes);
        $domain = new ConfigurationDomain(
            new DomainId('nodes'),
            $configuration,
        );

        (new NodesValidator())->validate($domain);
    }
}
