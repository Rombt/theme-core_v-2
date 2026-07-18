<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Compositions;

use Rombt\ThemeCore\ThemeConfiguration\Domains\Compositions\CompositionsConfiguration;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeIr;

final readonly class CompositionIr extends ThemeIr
{
    public function __construct(
        IrId $id,
        private CompositionsConfiguration $configuration,
    ) {
        parent::__construct($id);
    }

    public function configuration(): CompositionsConfiguration
    {
        return $this->configuration;
    }
}
