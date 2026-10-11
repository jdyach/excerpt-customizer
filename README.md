# Excerpt Customizer

Per-post control over excerpt word count and "read more" link text, available in both the Classic editor meta box and the Gutenberg block editor sidebar panel.

## Features
- Override the excerpt word count on a per-post basis (leave blank to use global default)
- Set custom "read more" link text per post
- Works in Classic editor (meta box) and Gutenberg (PluginSidebar)
- Hooks into `excerpt_length` and `excerpt_more` filters at priority 999 to reliably override theme/plugin values
- Cleans up meta when fields are left blank

## WordPress Concepts Demonstrated
| Concept | Where Used |
|---|---|
| `add_meta_box` + nonce save | `class-exc-meta-box.php` |
| `excerpt_length` / `excerpt_more` filters | `class-exc-filters.php` |
| `register_post_meta` with `show_in_rest` | `class-exc-block-sidebar.php` |
| Gutenberg `registerPlugin` / `PluginSidebar` | `assets/js/block-sidebar.js` |
| `delete_post_meta` for cleanup | `class-exc-meta-box.php` |

## Requirements
- WordPress 6.0+ / PHP 8.0+
## License
GPL-2.0-or-later
