<?php

class Video_Taxonomy {

    // init to register taxonomy
    public function register() {
        add_action( 'init', [ $this, 'register_taxonomy' ] );
    }

    // Register custom taxonomy "video_type" for post type "video"
    public function register_taxonomy() {
        register_taxonomy( 'video_type', 'video', [
            'labels' => [
                'name' => __( 'Video Types', 'video-library' ),
                'singular_name' => __( 'Video Type', 'video-library' ),
            ],
            'hierarchical' => true,
            'public' => true,
        ] );

        $this->maybe_add_default_terms();
    }

    // Add default taxonomy terms Movie and Series
    private function maybe_add_default_terms() {
        if ( ! term_exists( 'Movie', 'video_type' ) ) {
            wp_insert_term( 'Movie', 'video_type' );
        }
        if ( ! term_exists( 'Series', 'video_type' ) ) {
            wp_insert_term( 'Series', 'video_type' );
        }
    }
}