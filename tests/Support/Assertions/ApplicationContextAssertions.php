<?php

declare(strict_types=1);

namespace Tests\Support\Assertions;

use PHPUnit\Framework\Assert;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextInterface;

final class ApplicationContextAssertions
{
    public static function assertHasKey(
        ApplicationContextInterface $context,
        string $key
    ): void {
        Assert::assertTrue(
            $context->has($key),
            sprintf('Failed asserting that context has key "%s".', $key)
        );
    }

    public static function assertHasValue(
        ApplicationContextInterface $context,
        string $key,
        object $expected
    ): void {
        Assert::assertTrue($context->has($key));

        Assert::assertSame(
            $expected,
            $context->get($key)
        );
    }

    public static function assertCount(
        ApplicationContextInterface $context,
        int $expectedCount
    ): void {
        Assert::assertCount(
            $expectedCount,
            $context->all(),
            'Context entry count mismatch.'
        );
    }
}
