# navigation_01

## Purpose

Displays the primary site navigation.

## Supported Architectures

- Classic Theme (`component.classic.php`)
- Block Theme (`component.block.html`)

## Responsibilities

- display the primary navigation;
- rely on the menu assigned by the theme;
- use the native navigation implementation of the target architecture.

## Styling

The component contains no dedicated CSS.

It relies on standard HTML and WordPress block markup and may be styled via `theme.json`.

## Consumers

Typically used by the site header and other layout compositions that require the primary navigation.
