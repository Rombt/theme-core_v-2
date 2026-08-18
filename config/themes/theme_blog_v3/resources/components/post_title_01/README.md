# post_title_01

## Purpose

Displays the title of the current post.

## Supported Architectures

- Classic Theme (`component.classic.php`)
- Block Theme (`component.block.html`)

## Responsibilities

- display the current post title;
- provide the title for singular content.

## Strategy

Uses the `cached` strategy.

The component is intended for reuse without changing its output during a single request.

## Styling

The component contains no dedicated CSS.

It relies on standard HTML and WordPress block markup.

## Consumers

Used by `single` templates and other compositions displaying singular content.
