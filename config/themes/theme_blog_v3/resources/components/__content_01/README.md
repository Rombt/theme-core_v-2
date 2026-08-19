# content_01

## Purpose

Post Content — отображает содержимое текущей записи или страницы.

## Responsibilities

- вывод содержимого записи;
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

Ресурс отвечает только за представление содержимого записи.

Предполагается, что текущий пост уже определён вызывающим шаблоном.

## Styling

Ресурс не содержит собственных CSS.

Для оформления используются:

- стандартные классы WordPress;
- глобальные стили темы.
