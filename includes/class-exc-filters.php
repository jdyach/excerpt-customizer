<?php
/**
 * Applies the per-post excerpt length and read-more text on the front end.
 *
 * @package Excerpt_Customizer
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class EXC_Filters {

    public static function init(): void {
        add_filter( 'excerpt_length',   [ __CLASS__, 'custom_length' ], 999 );
        add_filter( 'excerpt_more',     [ __CLASS__, 'custom_more' ],   999 );
    }

    public static function custom_length( int $default ): int {
        $post_id = get_the_ID();
        if ( ! $post_id ) { return $default; }
        $length = get_post_meta( $post_id, EXC_LENGTH_KEY, true );
        return $length ? (int) $length : $default;
    }

    public static function custom_more( string $default ): string {
        $post_id = get_the_ID();
        if ( ! $post_id ) { return $default; }
        $more = get_post_meta( $post_id, EXC_MORE_KEY, true );
        if ( ! $more ) { return $default; }
        return sprintf( '&hellip; <a class="exc-more-link" href="%s">%s</a>',
            esc_url( get_permalink( $post_id ) ),
            esc_html( $more )
        );
    }
}
