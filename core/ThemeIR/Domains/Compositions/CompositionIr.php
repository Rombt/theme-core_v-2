<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Compositions;

use Rombt\ThemeCore\ThemeComponents\Domains\Compositions\CompositionCollection;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeIr;

final readonly class CompositionIr extends ThemeIr
{
    public function __construct(
        IrId $id,
        private CompositionCollection $compositions,
    ) {
        parent::__construct($id);
    }

    public function compositions(): CompositionCollection
    {
        return $this->compositions;
    }
}
