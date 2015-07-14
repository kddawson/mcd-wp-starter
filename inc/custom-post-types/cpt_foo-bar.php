<?php
/**
 * custom post type: FooBar
 *
 */
if ( !class_exists('FooBar') ):

class FooBar
{
    /**
     * Initialize & hook into WP
     */
    public function __construct() {
        add_action( 'init', array($this, 'register_post_type'), 0 );
        add_action( 'init', array($this, 'register_taxonomy'), 0 );
        add_action( 'wp_enqueue_scripts', array($this, 'load_styles'), 101 );
        add_action( 'admin_notices', array($this, 'admin_notice') );
        add_action( 'after_setup_theme', array($this, 'after_setup_theme') );
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
        $labels = array(
            'name' => _x("Foo Bar", "post type general name"),
            'singular_name' => _x("Foo Bar", "post type singular name"),
            'menu_name' => 'Foo Bars',
            'add_new' => _x("Add New", "Foo Bar item"),
            'add_new_item' => __("Add New Foo Bar"),
            'edit_item' => __("Edit Foo Bar"),
            'new_item' => __("New Foo Bar"),
            'view_item' => __("View Foo Bar"),
            'search_items' => __("Search Foo Bars"),
            'not_found' =>  __("No Foo Bars Found"),
            'not_found_in_trash' => __("No Foo Bars Found in Trash"),
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

}

$FooBar = new FooBar();

endif;
