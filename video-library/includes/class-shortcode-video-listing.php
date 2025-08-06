<?php

class Video_Listing_Shortcode {

    public function register() {
        add_shortcode( 'video_listing', [ $this, 'render_shortcode' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'vp_register_assets'] );
    }

     // Register and enqueue plugin CSS and JS
    public function vp_register_assets() {
        // Register CSS file
        wp_register_style(
            'vp-style',
            VL_DIR_URL . 'assets/css/style.css',
            array(),
            '1.0.0'
        );
    }

    // Render the video listing via shortcode
    public function render_shortcode( $atts ) {
        ob_start();

        // Enqueue registered files
        wp_enqueue_style('vp-style');
        $video_type = isset( $_GET['video_type'] ) ? sanitize_text_field( $_GET['video_type'] ) : '';

        $terms = get_terms( [
            'taxonomy' => 'video_type',
            'hide_empty' => false,
        ] );

        // Render filter dropdown
        echo '<form method="get">';
        echo '<select name="video_type" onchange="this.form.submit()">';
        echo '<option value="">' . __( 'All', 'video-library' ) . '</option>';
        foreach ( $terms as $term ) {
            $selected = selected( $video_type, $term->slug, false );
            echo "<option value='{$term->slug}' $selected>{$term->name}</option>";
        }
        echo '</select>';
        echo '</form>';

        $args = [
            'post_type' => 'video',
            'posts_per_page' => -1,
        ];

        if ( $video_type ) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'video_type',
                    'field' => 'slug',
                    'terms' => $video_type,
                ]
            ];
        }

        $query = new WP_Query( $args );

        // Display videos in grid
        if ( $query->have_posts() ) {
            echo '<div class="video-listing video-grid">';
            while ( $query->have_posts() ) {
                $query->the_post();
                $video_url = get_post_meta( get_the_ID(), '_video_url', true );
                echo '<div class="video-item">';
                echo '<h3>' . esc_html( get_the_title() ) . '</h3>';
                if ( $video_url ) {
                    $embed_url = preg_replace( '/watch\?v=([a-zA-Z0-9_-]+)/', 'embed/$1', $video_url );
                    echo '<iframe width="560" height="315" src="' . esc_url( $embed_url ) . '" frameborder="0" allowfullscreen></iframe>';
                }
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>' . __( 'No videos found.', 'video-library' ) . '</p>';
        }

        wp_reset_postdata();
        return ob_get_clean();
    }
}