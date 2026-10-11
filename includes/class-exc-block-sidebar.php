<?php
/**
 * Registers post meta for the REST API and enqueues the block editor sidebar.
 *
 * @package Excerpt_Customizer
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class EXC_Block_Sidebar {

    public static function init(): void {
        add_action( 'init', [ __CLASS__, 'register_meta' ] );
        add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue' ] );
    }

    public static function register_meta(): void {
        $args_base = [ 'show_in_rest' => true, 'single' => true, 'auth_callback' => fn() => current_user_can( 'edit_posts' ) ];
        $post_types = get_post_types( [ 'public' => true ] );
        foreach ( $post_types as $pt ) {
            register_post_meta( $pt, EXC_LENGTH_KEY, array_merge( $args_base, [ 'type' => 'integer' ] ) );
            register_post_meta( $pt, EXC_MORE_KEY,   array_merge( $args_base, [ 'type' => 'string' ] ) );
        }
    }

    public static function enqueue(): void {
        wp_enqueue_script( 'exc-block-sidebar', EXC_PLUGIN_URL . 'assets/js/block-sidebar.js',
            [ 'wp-plugins', 'wp-edit-post', 'wp-components', 'wp-data', 'wp-element', 'wp-i18n' ], EXC_VERSION, true );
        wp_enqueue_style( 'exc-admin', EXC_PLUGIN_URL . 'assets/css/admin.css', [], EXC_VERSION );
    }
}
