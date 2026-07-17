<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Infrastructure\Logging;

use ReflectionClass;
use ReflectionProperty;
use DateTimeInterface;
use JsonSerializable;
use Stringable;
use UnitEnum;
use SplObjectStorage;
use Rombt\ThemeCore\Contracts\Logging\ObjectDumperInterface;

final class PrettyObjectDumper implements ObjectDumperInterface
{
    private readonly SplObjectStorage $visited;

    public function __construct()
    {
        $this->visited = new SplObjectStorage();
    }


    public function dump(mixed $value): string
    {
        $this->visited->removeAll($this->visited);

        return $this->format($value, 0);
    }

    private function format(
        mixed $value,
        int $depth,
    ): string {

        if ($value instanceof DateTimeInterface) {
            return $value->format(DATE_ATOM);
        }

        if ($value instanceof UnitEnum) {
            return $value->name;
        }

        if ($value instanceof JsonSerializable) {
            return $this->format(
                $value->jsonSerialize(),
                $depth,
            );
        }

        if (
            $value instanceof Stringable
            && !$value instanceof UnitEnum
        ) {
            return (string) $value;
        }

        if (is_null($value)) {
            return 'null';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_scalar($value)) {
            return var_export($value, true);
        }

        if (is_array($value)) {
            return $this->formatArray($value, $depth);
        }

        if (is_object($value)) {
            return $this->formatObject($value, $depth);
        }

        return sprintf(
            '[%s]',
            gettype($value),
        );
    }

    private function formatArray(
        array $value,
        int $depth,
    ): string {
        if ($value === []) {
            return '[]';
        }

        $indent = $this->indent($depth);
        $childIndent = $this->indent($depth + 1);

        $lines = ['['];

        foreach ($value as $key => $item) {
            $lines[] = sprintf(
                '%s%s: %s',
                $childIndent,
                (string) $key,
                $this->format($item, $depth + 1),
            );
        }

        $lines[] = $indent . ']';

        return implode(PHP_EOL, $lines);
    }

    private function formatObject(
        object $value,
        int $depth,
    ): string {
        if ($this->visited->contains($value)) {
            return sprintf(
                '%s { *RECURSION* }',
                $value::class,
            );
        }

        $this->visited->attach($value);

        $reflection = new ReflectionClass($value);

        $indent = $this->indent($depth);
        $childIndent = $this->indent($depth + 1);

        $lines = [
            $reflection->getShortName() . ' {',
        ];

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);

            $lines[] = sprintf(
                '%s%s: %s',
                $childIndent,
                $property->getName(),
                $this->format(
                    $this->getPropertyValue(
                        $property,
                        $value,
                    ),
                    $depth + 1,
                ),
            );
        }

        $lines[] = $indent . '}';

        return implode(PHP_EOL, $lines);
    }

    private function getPropertyValue(
        ReflectionProperty $property,
        object $object,
    ): mixed {
        return $property->getValue($object);
    }

    private function indent(
        int $depth,
    ): string {
        return str_repeat('    ', $depth);
    }
}
