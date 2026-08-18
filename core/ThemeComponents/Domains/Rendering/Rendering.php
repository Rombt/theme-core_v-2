<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeComponents\Domains\Rendering;

enum Rendering: string
{
    case Inline = 'inline';

    case Template = 'template';

    case Header = 'header';

    case Footer = 'footer';

    case Sidebar = 'sidebar';

    case SearchForm = 'search-form';

    case TemplatePart = 'template-part';

    case Comments = 'comments';
}
