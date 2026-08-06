<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Nodes\ValueObjects;

enum ResourceArchitecture: string
{
    case Classic = 'classic';
    case Block = 'block';

    // сюда добавлять новые архитектуры
}
