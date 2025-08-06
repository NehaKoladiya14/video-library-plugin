<?php

class Video_Post_Type {
    
    // init to register post type
    public function register() {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    // Register custom post type "video"
    public function register_post_type() {
        register_post_type( 'video', [
            'labels' => [
                'name' => __( 'Videos', 'video-library' ),
                'singular_name' => __( 'Video', 'video-library' ),
            ],
            'public' => true,
            'has_archive' => true,
            'supports' => [ 'title' ],
            'rewrite' => [ 'slug' => 'videos' ],
        ] );
    }
}
