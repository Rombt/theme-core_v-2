# page_content_01

## Purpose

Page Content — отображает содержимое текущей страницы.

## Responsibilities

- вывод содержимого страницы;
- поддержка Gutenberg;
- поддержка Elementor;
- вывод постраничной навигации.

## Resource Files

- `content.classic.php` — реализация для Classic Theme.
- `content.block.html` — реализация для Block Theme.

## Architecture

Поддерживаемые архитектуры:

- Classic Theme;
- Block Theme.

Ресурс отвечает только за представление содержимого текущей страницы.

Предполагается, что текущая страница уже определена вызывающим шаблоном.

## Styling

Ресурс не содержит собственных CSS.

Для оформления используются:

- стандартные классы WordPress;
- глобальные стили темы.
