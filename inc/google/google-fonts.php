<?php
/**
 * Google Fonts
 * See: http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
 *
 * @package mcd
 */


function mcd_font_url() {
    $font_url = '';

    /*
     * Translators: If there are characters in your language that are not supported
     * by the font, translate this to 'off'. Do not translate into your own language.
     */

    if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'mcd' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Open Sans:300,400,700,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
    }

    return $font_url;
}

if( !function_exists("mcd_theme_fonts") ) {
    function mcd_theme_fonts() {
        wp_enqueue_style(
            'mcd-google-fonts',
            mcd_font_url(),
            array(),
            null
        );
    }
    add_action( 'wp_enqueue_scripts', 'mcd_theme_fonts' );
}

function mcd_editor_fonts() {
    add_editor_style( array( 'editor-style.css', mcd_font_url() ) );
}
add_action( 'after_setup_theme', 'mcd_editor_fonts' );
