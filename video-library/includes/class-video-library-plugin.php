<?php

class Video_Library_Plugin {
    
    // Include necessary class files
    public function run() {
        require_once VL_DIR_PATH . 'includes/class-post-type-video.php';
        require_once VL_DIR_PATH . 'includes/class-taxonomy-video-type.php';
        require_once VL_DIR_PATH . 'includes/class-meta-box-video-url.php';
        require_once VL_DIR_PATH . 'includes/class-shortcode-video-listing.php';

        ( new Video_Post_Type() )->register();
        ( new Video_Taxonomy() )->register();
        ( new Video_URL_Meta_Box() )->init();
        ( new Video_Listing_Shortcode() )->register();
    }
}