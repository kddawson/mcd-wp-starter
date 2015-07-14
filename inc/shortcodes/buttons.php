<?php
/**
 * Plugin Name: mcd Shortcode Plugin
 * Description:
 * Version: 1.0
 *
 * See: http://wp.smashingmagazine.com/2012/05/01/wordpress-shortcodes-complete-guide/
 * Add button to TinyMCE plugin: http://www.wpexplorer.com/wordpress-tinymce-tweaks/
 */

/** ----------------------------------------------------------------------------------------
 * Twitter Bootstrap-style "buttons"
 * Example code: [button type="default" size="default" text="Button text" url="http://google.com"]
 * -----------------------------------------------------------------------------------------
 */

function buttons( $atts, $content = null ) {
    extract( shortcode_atts( array(
    'type' => 'default', /* primary, default, info, success, danger, warning, link */
    'size' => 'default', /* xs, sm, lg */
    'url'  => '',
    'text' => '',
    ), $atts ) );

    if($type == "default"){
        $type = "default";
    }
    else {
        $type = "btn-" . $type;
    }

    if($size == "default"){
        $size = "";
    }
    else {
        $size = "btn-" . $size;
    }

    $output = '<a href="' . $url . '" class="btn '. $size .' '. $type .'">';
    $output .= $text;
    $output .= '</a>';

    return $output;
}

add_shortcode('button', 'buttons');

// Hooks your functions into the correct filters
function mcd_add_mce_button() {
    // check user permissions
    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
        return;
    }
    // check if WYSIWYG is enabled
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'mcd_add_tinymce_plugin' );
        add_filter( 'mce_buttons', 'mcd_register_mce_button' );
    }
}
add_action('admin_head', 'mcd_add_mce_button');

// Declare script for new button
function mcd_add_tinymce_plugin( $plugin_array ) {
    $plugin_array['mcd_mce_button'] = get_template_directory_uri() .'/inc/shortcodes/mce-buttons.js';
    return $plugin_array;
}

// // Register new button in the editor
function mcd_register_mce_button( $buttons ) {
    array_push( $buttons, 'mcd_mce_button' );
    return $buttons;
}
