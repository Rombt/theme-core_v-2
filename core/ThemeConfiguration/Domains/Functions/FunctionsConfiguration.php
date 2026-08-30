<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Functions;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;

final readonly class FunctionsConfiguration implements ConfigurationDomainInterface
{
    private FunctionDefinitionCollection $functions;

    /**
     * @param array<string, array<string, mixed>> $functions
     */
    public function __construct(array $functions)
    {
        $collection = [];

        foreach ($functions as $id => $function) {
            $collection[] = new FunctionDefinition(
                id: $id,
                type: (string) ($function['type'] ?? ''),
                resource: (string) ($function['resource'] ?? ''),
                name: (string) ($function['name'] ?? ''),
                description: isset($function['description'])
                    ? (string) $function['description']
                    : null,
                configuration: is_array($function['configuration'] ?? null)
                    ? $function['configuration']
                    : [],
            );
        }

        $this->functions = new FunctionDefinitionCollection($collection);
    }

    public function functions(): FunctionDefinitionCollection
    {
        return $this->functions;
    }
}
