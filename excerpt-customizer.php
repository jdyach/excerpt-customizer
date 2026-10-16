<?php
/**
 * Plugin Name:       Excerpt Customizer
 * Plugin URI:        https://github.com/jdyach/excerpt-customizer
 * Description:       Per-post control over excerpt word count and "read more" text, in both the Classic editor meta box and the Gutenberg sidebar panel.
 * Version:           1.1.0
 * Author:            Jacqui Dyach
 * Author URI:        https://jacquid.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       excerpt-customizer
 * Requires at least: 6.0
 * Requires PHP:      8.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'EXC_VERSION',    '1.1.0' );
define( 'EXC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'EXC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'EXC_LENGTH_KEY', '_exc_length' );
define( 'EXC_MORE_KEY',   '_exc_more' );

require_once EXC_PLUGIN_DIR . 'includes/class-exc-meta-box.php';
require_once EXC_PLUGIN_DIR . 'includes/class-exc-block-sidebar.php';
require_once EXC_PLUGIN_DIR . 'includes/class-exc-filters.php';
require_once EXC_PLUGIN_DIR . 'includes/class-exc-block-themes.php';

function exc_init(): void {
    EXC_Meta_Box::init();
    EXC_Block_Sidebar::init();
    EXC_Filters::init();
    EXC_Block_Themes::init();
}
add_action( 'plugins_loaded', 'exc_init' );
