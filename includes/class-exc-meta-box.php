<?php
/**
 * Classic editor meta box for per-post excerpt settings.
 *
 * @package Excerpt_Customizer
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

class EXC_Meta_Box {

    public static function init(): void {
        add_action( 'add_meta_boxes', [ __CLASS__, 'register' ] );
        add_action( 'save_post',      [ __CLASS__, 'save' ] );
        add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue' ] );
    }

    public static function register(): void {
        $post_types = get_post_types( [ 'public' => true ] );
        foreach ( $post_types as $pt ) {
            add_meta_box( 'exc_customizer', __( 'Excerpt Customizer', 'excerpt-customizer' ), [ __CLASS__, 'render' ], $pt, 'side' );
        }
    }

    public static function render( WP_Post $post ): void {
        $length = get_post_meta( $post->ID, EXC_LENGTH_KEY, true );
        $more   = get_post_meta( $post->ID, EXC_MORE_KEY,   true );
        wp_nonce_field( 'exc_save', 'exc_nonce' );
        ?>
        <p>
            <label for="exc_length"><strong><?php esc_html_e( 'Word count', 'excerpt-customizer' ); ?></strong></label><br>
            <input type="number" id="exc_length" name="exc_length" value="<?php echo esc_attr( $length ); ?>" min="1" max="500" class="widefat" placeholder="<?php esc_attr_e( 'Default (55)', 'excerpt-customizer' ); ?>" />
            <span class="description"><?php esc_html_e( 'Leave blank to use the global default.', 'excerpt-customizer' ); ?></span>
        </p>
        <p>
            <label for="exc_more"><strong><?php esc_html_e( '"Read more" text', 'excerpt-customizer' ); ?></strong></label><br>
            <input type="text" id="exc_more" name="exc_more" value="<?php echo esc_attr( $more ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. Continue reading…', 'excerpt-customizer' ); ?>" />
        </p>
        <?php
    }

    public static function save( int $post_id ): void {
        if ( ! isset( $_POST['exc_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['exc_nonce'] ), 'exc_save' ) ) { return; }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
        if ( wp_is_post_revision( $post_id ) ) { return; }
        if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

        $length = isset( $_POST['exc_length'] ) ? absint( $_POST['exc_length'] ) : '';
        $more   = isset( $_POST['exc_more'] )   ? sanitize_text_field( wp_unslash( $_POST['exc_more'] ) ) : '';

        if ( $length ) {
            update_post_meta( $post_id, EXC_LENGTH_KEY, $length );
        } else {
            delete_post_meta( $post_id, EXC_LENGTH_KEY );
        }

        if ( $more ) {
            update_post_meta( $post_id, EXC_MORE_KEY, $more );
        } else {
            delete_post_meta( $post_id, EXC_MORE_KEY );
        }
    }

    public static function enqueue( string $hook ): void {
        if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) { return; }
        wp_enqueue_style( 'exc-admin', EXC_PLUGIN_URL . 'assets/css/admin.css', [], EXC_VERSION );
    }
}
