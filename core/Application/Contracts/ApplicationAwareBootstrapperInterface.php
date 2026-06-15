<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Bootstrap\Contracts;

use Rombt\ThemeCore\Application\Contracts\ApplicationContextBuilderInterface;

interface ApplicationAwareBootstrapperInterface
{
    public function bootstrap(
        ApplicationContextBuilderInterface $builder
    ): void;
}
