<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

use Rombt\ThemeCore\Theme\Contracts\ThemeComponentBuilderInterface;
use Rombt\ThemeCore\ThemeConfiguration\ConfigurationDomain;

final class ThemeComponentBuilderRegistry
{
    /**
     * @param ThemeComponentBuilderInterface[] $builders
     */
    public function __construct(private readonly array $builders)
    {
    }

    public function builderFor(ConfigurationDomain $domain): ThemeComponentBuilderInterface
    {


        foreach ($this->builders as $builder) {
            if ($builder->supports($domain)) {
                return $builder;
            }
        }

        throw new \RuntimeException(
            sprintf(
                'No ThemeComponentBuilder registered for domain "%s".',
                $domain->id()->value(),
            ),
        );
    }
}
