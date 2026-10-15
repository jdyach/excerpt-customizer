<?php
/**
 * Block theme support for the per-post excerpt settings.
 *
 * Classic themes call get_the_excerpt(), so the excerpt_length and
 * excerpt_more filters in EXC_Filters are enough. Block themes render the
 * core Post Excerpt block instead, which trims to its own `excerptLength`
 * attribute and builds its own "read more" link from `moreText`, so those
 * filters never take effect.
 *
 * This class bridges the gap: when a Post Excerpt block renders a post that
 * has custom settings, it renders the block again with the post's length and
 * read-more text as block attributes. Posts without custom settings are left
 * exactly as the theme designed them.
 *
 * @package Excerpt_Customizer
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class EXC_Block_Themes {

    /** Prevents recursion while the block is re-rendered. */
    private static bool $rendering = false;

    public static function init(): void {
        add_filter( 'render_block_core/post-excerpt', [ __CLASS__, 'apply_post_settings' ], 10, 3 );
    }

    /**
     * Re-render the Post Excerpt block using the post's custom settings.
     *
     * @param string   $content  Rendered block HTML.
     * @param array    $block    Parsed block.
     * @param WP_Block $instance Block instance (provides the postId context).
     * @return string Block HTML.
     */
    public static function apply_post_settings( string $content, array $block, WP_Block $instance ): string {
        if ( self::$rendering ) {
            return $content;
        }

        $post_id = (int) ( $instance->context['postId'] ?? 0 );
        if ( ! $post_id ) {
            return $content;
        }

        $length = (int) get_post_meta( $post_id, EXC_LENGTH_KEY, true );
        $more   = (string) get_post_meta( $post_id, EXC_MORE_KEY, true );
        if ( ! $length && '' === $more ) {
            return $content;
        }

        $attrs = $block['attrs'] ?? [];
        if ( $length ) {
            $attrs['excerptLength'] = $length;
        }
        if ( '' !== $more ) {
            $attrs['moreText'] = esc_html( $more );
        }

        // The block adds its own link from moreText, so skip the classic
        // excerpt_more link while it renders to avoid showing two.
        remove_filter( 'excerpt_more', [ 'EXC_Filters', 'custom_more' ], 999 );
        self::$rendering = true;

        $rerendered = ( new WP_Block( array_merge( $block, [ 'attrs' => $attrs ] ), $instance->context ) )->render();

        self::$rendering = false;
        add_filter( 'excerpt_more', [ 'EXC_Filters', 'custom_more' ], 999 );

        return $rerendered;
    }
}
