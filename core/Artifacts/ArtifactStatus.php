<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts;

enum ArtifactStatus: string
{
    case CREATED = 'created';

    case PUBLISHED = 'published';
}
