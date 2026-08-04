# header

## Purpose

Represents the site header composition.

Defines the overall HTML structure of the header and the locations where child nodes are inserted.

The composition does not implement child components.

---

## Supported Architectures

- Classic Theme (`header.classic.php`)
- Block Theme (`header.block.html`)

---

## Responsibilities

- define the header container;
- define the layout of child nodes;
- provide composition slots for the Artifact Generator.

---

## Does not implement

- site title;
- logo;
- navigation;
- search;
- any other child component.

Each child node provides its own representation through its resource.

---

## Slot Composition

Example:

```text
@slot_1
@slot_2
```

The mapping between slots and child nodes is defined by the corresponding Composition, not by this resource.

---

## Styling

The composition contains no dedicated CSS.

It relies on shared theme styles and architecture-specific markup.
