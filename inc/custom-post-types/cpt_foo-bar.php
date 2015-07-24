<?php
/**
 * Custom Post Type: FooBar
 * Based on https://github.com/Kevinlearynet/WP-Meet-The-Team
 *
 */
if ( !class_exists('FooBar') ):

class FooBar {
    /**
     * Initialize & hook into WP
     */
    public function __construct() {
        add_action( 'init', array($this, 'register_post_type'), 0 );
        add_action( 'init', array($this, 'register_taxonomy'), 0 ); // optional
        add_action( 'admin_notices', array($this, 'admin_notice') );
        add_action( 'after_setup_theme', array($this, 'after_setup_theme') );
    }


    /**
     * Theme setup
     *
     * Create a custom thumbnail size for this CPT
     */
    public function after_setup_theme() {
      add_image_size('foobar', 100, 100, true); // 100px x 100px with hard crop enabled
    }


    /**
     * Dependencies check
     *
     * Check to make sure we have the required plugin(s) installed.
     */
    public function dependencies_check() {
        return ( is_plugin_active('advanced-custom-fields/acf.php') ) ? true : false;
    }


    /**
     * Dependencies notifications
     *
     * Required plugin isn't installed, notify user
     */
    public function admin_notice() {

        // Check for required plugins
        if ( $this->dependencies_check() )
            return;

        // Display message
        $install_link = admin_url('plugin-install.php?tab=search&type=term&s=Advanced+Custom+Fields&plugin-search-input=Search+Plugins');
        $html =  '<div class="error"><p>';
        $html .= '<strong>Foo Bar</strong> needs the <a href="http://www.advancedcustomfields.com/" target="_blank">Advanced Custom Fields</a> plugin to work. Please <a href="' . $install_link . '">install it now</a>.';
        $html .= '</p></div>';

        echo $html;
    }


    /**
     * Register post type
     */
    public function register_post_type() {

        // Labels
        $singular = 'Foo Bar';
        $plural = 'Foo Bars';
        $labels = array(
            'name' => _x($plural, "post type general name"),
            'singular_name' => _x($singular, "post type singular name"),
            'menu_name' => '$plural',
            'add_new' => _x("Add New", "$singular item"),
            'add_new_item' => __("Add New $singular"),
            'edit_item' => __("Edit $singular"),
            'new_item' => __("New $singular"),
            'view_item' => __("View $singular"),
            'search_items' => __("Search $plural"),
            'not_found' =>  __("No $plural Found"),
            'not_found_in_trash' => __("No $plural Found in Trash"),
            'parent_item_colon' => ''
        );

        // Register post type
        register_post_type('foobar' , array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => false,
            //'menu_icon' => get_template_directory_uri() . '/inc/custom-post-types/foobar-icon.png',
            'rewrite' => false,
            'supports' => array('title', 'editor', 'thumbnail')
        ) );
    }


    /**
     * Register `doohickie` taxonomy (optional)
     */
    public function register_taxonomy() {

        // Labels
        $singular = 'Doohickie';
        $plural = 'Doohickies';
        $labels = array(
            'name' => _x( $plural, "taxonomy general name"),
            'singular_name' => _x( $singular, "taxonomy singular name"),
            'search_items' =>  __("Search $singular"),
            'all_items' => __("All $singular"),
            'parent_item' => __("Parent $singular"),
            'parent_item_colon' => __("Parent $singular:"),
            'edit_item' => __("Edit $singular"),
            'update_item' => __("Update $singular"),
            'add_new_item' => __("Add New $singular"),
            'new_item_name' => __("New $singular Name"),
        );

        // Register and attach to `foobar` post type
        register_taxonomy( strtolower($singular), 'foobar', array(
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => false,
            'labels' => $labels
        ) );
    }

}

$FooBar = new FooBar();

endif;
