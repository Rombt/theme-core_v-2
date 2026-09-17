<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Assets;

enum AssetType: string
{
    case Style = 'style';

    case Script = 'script';

    case Font = 'font';

    case Image = 'image';
}
