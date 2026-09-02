<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Concepts\Functions;

use LogicException;
use Rombt\ThemeCore\ThemeIR\Contracts\FunctionRequirementSourceInterface;
use Rombt\ThemeCore\ThemeIR\ThemeIR;

final readonly class FunctionRequirementCollector
{
    public function collect(
        ThemeIR $themeIr,
    ): FunctionRequirementCollection {
        $requirements = [];
        $sequence = 0;

        foreach ($themeIr as $concept) {
            if (!$concept instanceof FunctionRequirementSourceInterface) {
                continue;
            }

            foreach ($concept->functionComponents() as $component) {
                $definition = $component->function();

                if ($definition === null) {
                    continue;
                }

                if (!$definition->enabled()) {
                    continue;
                }

                $order = $definition->order();

                if ($order < 0 || $order > 100) {
                    throw new LogicException(
                        sprintf(
                            'Function requirement order must be between 0 and 100, got %d.',
                            $order,
                        ),
                    );
                }

                $requirements[] = [
                    'requirement' => new FunctionRequirement(
                        resource: $definition->resource(),
                        order: $order,
                    ),
                    'sequence' => $sequence++,
                ];
            }
        }

        usort(
            $requirements,
            static function (array $a, array $b): int {
                $orderComparison = $a['requirement']->order()
                    <=> $b['requirement']->order();

                if ($orderComparison !== 0) {
                    return $orderComparison;
                }

                return $a['sequence'] <=> $b['sequence'];
            },
        );

        return new FunctionRequirementCollection(
            array_column($requirements, 'requirement'),
        );
    }
}
