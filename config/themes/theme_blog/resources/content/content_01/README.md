# content_01

## Purpose

Post Content — отображает содержимое текущей записи или страницы.

## Responsibilities

- вывод `the_content()`;
- поддержка Gutenberg;
- поддержка Elementor;
- вывод постраничной навигации через `wp_link_pages()`.

## Styling

Узел не содержит собственных CSS.

Для оформления используются:

- стандартные классы WordPress;
- стили, определённые в `theme.json`.

## Consumers

Используется шаблонами `single.php`, `page.php` и другими шаблонами, отображающими содержимое записи.
