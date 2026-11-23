# Resources

- `components/<resource-id>/classic.php` contains the Classic representation consumed by Theme Core v2.
- The `index` Resource owns its frontend source under `components/index/src/`.
- `assets/` contains ready Assets. Each Asset is stored below its architecture-specific `classic/` directory and is referenced by `assets.php`.
- `functions/` contains Classic PHP implementations for the Functions Domain. `helpers/` preserves the starter theme helper set; `theme_setup/` registers WordPress theme support and the header menu.

The SCSS and JavaScript sources under `components/index/src/` are compiled/bundled by Temforge. Theme Core v2 only consumes the generated CSS/JS files declared in `assets.php`.

Asset Function Requirement implementations use Theme Core's separate resource identity convention:

```text
resources/assets/<asset-type>/<asset-id>/classic/function.classic.php
```

The physical Asset files themselves remain under the `resource.path` declared in `assets.php`.
