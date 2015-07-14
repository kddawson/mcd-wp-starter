<?php
/**
 * Masonry
 * Enqueue WordPress-supplied Masonry (e.g. for home page articles)
 *
 * @package mcd
 */


function slug_masonry( ) {
    if ( is_home() ) {
        wp_enqueue_script( 'masonry' );
        wp_enqueue_script(
            'masonry-init',
            get_template_directory_uri().'/inc/masonry/masonry-init.js',
            array( 'masonry' ),
            null,
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'slug_masonry' );
