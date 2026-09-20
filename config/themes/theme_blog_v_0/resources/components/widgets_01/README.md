# widgets_01

## Purpose

Displays the primary WordPress widget area.

The component provides a dedicated location for
WordPress widgets assigned to the `primary-sidebar`
sidebar.

## Supported Architectures

- Classic Theme (`component.classic.php`)
- Block Theme (`component.block.html`)

## Responsibilities

- display the primary widget area;
- provide a WordPress sidebar location;
- use the native widget mechanism of the target architecture.

## Architecture

### Classic Theme

Uses the standard WordPress sidebar mechanism:

- `is_active_sidebar()`;
- `dynamic_sidebar()`.

The sidebar is identified by:

    primary-sidebar

### Block Theme

The resource provides the block representation
of the widget area.

The resource does not include the `sidebar`
template part and must not recursively reference
the `sidebar` Composition.

## Styling

The component contains no dedicated CSS.

It relies on:

- standard WordPress markup;
- shared theme styles;
- global styles where applicable.

## Consumers

Used by:

- `sidebar` Composition;
- templates and compositions that include a sidebar.
