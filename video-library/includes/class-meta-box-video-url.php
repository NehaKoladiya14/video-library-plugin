<?php

class Video_URL_Meta_Box {

    // Register hooks for meta box
    public function init() {
        add_action( 'add_meta_boxes', [ $this, 'add_meta_box' ] );
        add_action( 'save_post', [ $this, 'save_meta' ] );
    }

    // Add meta box to 'video' post type
    public function add_meta_box() {
        add_meta_box(
            'video_url_meta_box',
            __( 'Video URL (YouTube)', 'video-library' ),
            [ $this, 'render_meta_box' ],
            'video',
            'normal',
            'default'
        );
    }

    // Render the meta box HTML
    public function render_meta_box( $post ) {
        $value = get_post_meta( $post->ID, '_video_url', true );
            wp_nonce_field( 'save_video_url_meta', 'video_url_meta_nonce' );

            echo '<label for="video_url">' . __( 'Enter YouTube Embed Code or URL:', 'video-library' ) . '</label>';

            wp_editor(
                $value,
                'video_url',
                [
                    'textarea_name' => 'video_url',
                    'media_buttons' => false,
                    'textarea_rows' => 5,
                    'teeny'         => true,
                ]
         );
    }

        // Save the video URL metadata
    public function save_meta( $post_id ) {
        if ( ! isset( $_POST['video_url_meta_nonce'] ) || ! wp_verify_nonce( $_POST['video_url_meta_nonce'], 'save_video_url_meta' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['video_url'] ) ) {
            update_post_meta( $post_id, '_video_url', sanitize_text_field( $_POST['video_url'] ) );
        }
    }
}
