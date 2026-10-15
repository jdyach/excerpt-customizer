# Excerpt Customizer

Per-post control over excerpt word count and "read more" link text, available in both the Classic editor meta box and the Gutenberg block editor sidebar panel.

[![Try it live in WordPress Playground](https://img.shields.io/badge/Try%20it%20live-WordPress%20Playground-3858e9?logo=wordpress&logoColor=white&style=for-the-badge)](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/jdyach/excerpt-customizer/main/_playground/blueprint.json)

The live demo runs a real WordPress site in your browser with this plugin, the [Fieldnote](https://github.com/jdyach/fieldnote) block theme and sample content. It opens a blog index with three posts: one using the default excerpt, one trimmed to 8 words with custom "Keep reading" text, and one at 40 words with its own link text. Nothing to install.

## Features
- Override the excerpt word count on a per-post basis (leave blank to use global default)
- Set custom "read more" link text per post
- Works in Classic editor (meta box) and Gutenberg (PluginSidebar)
- Hooks into `excerpt_length` and `excerpt_more` filters at priority 999 to reliably override theme/plugin values
- Works in block themes too: the core Post Excerpt block is re-rendered with the post's length and read-more text (it ignores the classic filters)
- Cleans up meta when fields are left blank

## WordPress Concepts Demonstrated
| Concept | Where Used |
|---|---|
| `add_meta_box` + nonce save | `class-exc-meta-box.php` |
| `excerpt_length` / `excerpt_more` filters | `class-exc-filters.php` |
| `render_block_{name}` filter + `WP_Block` re-render (block themes) | `class-exc-block-themes.php` |
| `register_post_meta` with `show_in_rest` | `class-exc-block-sidebar.php` |
| Gutenberg `registerPlugin` / `PluginSidebar` | `assets/js/block-sidebar.js` |
| `delete_post_meta` for cleanup | `class-exc-meta-box.php` |

## Changelog

### 1.1.0
- Block theme support. The core Post Excerpt block trims to its own `excerptLength` attribute and builds its own link from `moreText`, so per-post settings had no effect in block themes. Posts with custom settings now have that block re-rendered with their values; other posts are unchanged.
- WordPress Playground live demo.

## Requirements
- WordPress 6.0+ / PHP 8.0+
## License
GPL-2.0-or-later
