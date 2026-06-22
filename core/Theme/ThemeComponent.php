<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Theme;

use Rombt\ThemeCore\Theme\Contracts\ThemeComponentInterface;

final readonly class ThemeComponent
{
    public function __construct(
        private ComponentId $id,
        private ThemeComponentInterface $component,
    ) {
    }

    public function id(): ComponentId
    {
        return $this->id;
    }

    public function component(): ThemeComponentInterface
    {
        return $this->component;
    }
}
