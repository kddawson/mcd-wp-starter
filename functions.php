<?php
/**
 * mcd functions and definitions
 * Site-specific (customised) functions, e.g. custom post types should be written into a functionality plugin
 * See: https://css-tricks.com/wordpress-functionality-plugins/
 * @package mcd
 */


if ( ! function_exists( 'mcd_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mcd_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on wp-starter, use a find and replace
	 * to change 'mcd' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'mcd', get_template_directory() . '/languages' );

    // Integrate Twitter Bootstrap
    //require get_template_directory() . '/inc/bootstrap/wp-bootstrap.php';

    // Google fonts
    require get_template_directory() . '/inc/google/google-fonts.php';

    // Custom template tags for this theme
    require get_template_directory() . '/inc/template-tags.php';

    // Custom comments
    require get_template_directory() . '/inc/comments/user-comments.php';

    // Recommend some default plugins (saves searching for them)
    require get_template_directory() . '/inc/recommend/tgm-plugin-recommendations.php';

    // List child/sibling pages
    //require get_template_directory() . '/inc/childpages/childpages.php';

    // Masonry tiles
    //require get_template_directory() . '/inc/masonry/masonry.php';

    // Customizer additions
    //require get_template_directory() . '/inc/customizer.php';

    // Load Jetpack compatibility file
    //require get_template_directory() . '/inc/jetpack.php';

    /** -----------------------------------------------------------------------------
     * Custom Shortcodes in the visual editor
     *
     * ------------------------------------------------------------------------------
     */
    //require get_template_directory() . '/inc/shortcodes/buttons.php';


    /** -----------------------------------------------------------------------------
     * Custom Post Types
     *
     * ------------------------------------------------------------------------------
     */
    require get_template_directory() . '/inc/custom-post-types/cpt_foo-bar.php';


    /** -----------------------------------------------------------------------------
     * Here's all the things this (parent) theme supports,
     * by adding them here they can be overridden in a child theme
     * ------------------------------------------------------------------------------
     */

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

    // This theme uses post thumbnails
    // See: http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

    /*
     * This is a global variable that sets the maximum width of content (such as uploaded images) in your theme.
     * It prevents large images from overflowing the main content area.
     * Set the content width based on the theme's design and stylesheet.
     */
    if ( ! isset( $content_width ) )
        $content_width = 640; /* pixels */

    // Switch default core markup for search form, comment form, and comments to output valid HTML5
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ) );

    // Add support for a variety of post formats
    // See: http://codex.wordpress.org/Post_Formats
    add_theme_support( 'post-formats',
        array(
            'aside',   // title-less blurb
            'gallery', // gallery of images
            'link',    // quick link to other site
            'image',   // an image
            'quote',   // a quick quote
            'status',  // a Facebook like status update
            'video',   // video
            'audio',   // audio
            'chat'     // chat transcript
        )
    );

    // Set up the WordPress core custom background feature
    add_theme_support( 'custom-background', apply_filters( 'mcd_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );

    // This theme styles the visual editor with editor-style.css to match the theme style
    add_editor_style();


    /** -----------------------------------------------------------------------------
     * Theme customisations
     * ------------------------------------------------------------------------------
     */

    // Add JavaScript the correct way
    add_action('wp_enqueue_scripts', 'mcd_theme_js');

    // Add CSS files the correct way
    add_action('wp_enqueue_scripts', 'mcd_theme_styles');

    // Modify the excerpt length
    add_filter('excerpt_length', 'mcd_excerpt_length', 999);

    // Modify the excerpt "more" indicator
    add_filter('excerpt_more', 'mcd_excerpt_more');

    // Disable jump in "read more" link
    add_filter( 'the_content_more_link', 'mcd_remove_more_jump_link' );

    // Remove `p` tags from inserted images
    add_filter('the_content', 'filter_ptags_on_images');

    // Add custom feed content
    add_filter('the_excerpt_rss', 'mcd_add_feed_content');
    add_filter('the_content', 'mcd_add_feed_content');

    // Delay the feed publish a few mins in case you want to do a quick edit after publishing
    add_filter('posts_where', 'mcd_publish_later_on_feed');

    // Remove height/width attributes on images so they can be responsive
    add_filter( 'post_thumbnail_html', 'mcd_remove_thumbnail_dimensions', 10, 3 );
    add_filter( 'image_send_to_editor', 'mcd_remove_thumbnail_dimensions', 10, 3 );
    add_filter( 'wp_get_attachment_link', 'mcd_remove_thumbnail_dimensions', 10, 3 );


    /** -----------------------------------------------------------------------------
     * Login and admin customisations
     * ------------------------------------------------------------------------------
     */

    // Remove log-in error messages
    add_filter('login_errors',create_function('$a', "return null;"));

    // Disable the admin bar (front end only)
    //add_filter('show_admin_bar', '__return_false');

    // Custom admin login logo
    add_action('login_head', 'mcd_login_logo');
    // Use your own external URL logo link
    add_filter('login_headerurl', 'mcd_url_login');

    add_action('wp_dashboard_setup', 'mcd_dashboard_widgets');
    add_filter('tiny_mce_before_init', 'change_mce_options');


    /** -----------------------------------------------------------------------------
     * <head> customisations
     * ------------------------------------------------------------------------------
     */

    // Enable threaded comments
    add_action('get_header', 'enable_threaded_comments');


    /** -----------------------------------------------------------------------------
     * Register the menu
     * ------------------------------------------------------------------------------
     */

    // This theme uses `wp_nav_menu()` in one location
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'mcd' ),
    ) );


    /** -----------------------------------------------------------------------------
     * Sidebar and widget customisations
     * ------------------------------------------------------------------------------
     */

    /* Add your sidebars function to the `widgets_init` action hook. */
    add_action('widgets_init', 'mcd_widgets_init');

    // Removes the default styles that are packaged with the Recent Comments widget
    add_action('widgets_init', 'mcd_remove_recent_comments_style');

    // Allow shortcodes to run inside widget boxes
    if (!is_admin())
        add_filter( 'widget_text', 'shortcode_unautop', 11);
        add_filter('widget_text', 'do_shortcode', 11);


    /** -----------------------------------------------------------------------------
     * Comments customisations
     * ------------------------------------------------------------------------------
     */

    // We have spam protection, so let's thank comment authors
    remove_filter('pre_comment_content', 'wp_rel_nofollow');
    add_filter('get_comment_author_link', 'xwp_dofollow');
    add_filter('post_comments_link', 'xwp_dofollow');
    add_filter('comment_reply_link', 'xwp_dofollow');
    add_filter('comment_text', 'xwp_dofollow');
    add_filter('pre_comment_content', 'encode_code_in_comment');
}
endif; // end mcd_setup

// Tell WordPress to run `mcd_setup()` when the `after_setup_theme` hook is run
add_action( 'after_setup_theme', 'mcd_setup' );

// Implement the Custom Header feature
// Runs the `after_setup_theme` hook separately to keep config in one place
//require get_template_directory() . '/inc/custom-header.php';


/** ----------------------------------------------------------------------------------------
 * Theme customisations
 * -----------------------------------------------------------------------------------------
 */

// Enqueue JavaScript
if( !function_exists( "mcd_theme_js" ) ) {
    function mcd_theme_js(){

        if ( !is_admin() ){
            if ( is_singular() AND comments_open() AND ( get_option( 'thread_comments' ) == 1) )
            wp_enqueue_script( 'comment-reply' );
        }

        /**
         * Register javaScript Libraries
         */
        wp_register_script(
            'modernizr',
            get_template_directory_uri() . '/assets/js/libs/modernizr-2.8.3.min.js',
            array('jquery'),
            '2.8.3'
        );


        /**
         * Register config / bespoke files
         */

        // Enqueue project JS in the footer by setting $in_footer = true
        wp_register_script(
            'mcd-js',
            get_template_directory_uri() . '/assets/dist/js/project.min.js',
            array('jquery'),    // comma-separated dependencies
            '1.0',              // cache-busting version number
            true                // load before closing </body> tag
        );


        /**
         * Enqueue jQuery Libraries
         */
        wp_enqueue_script( 'modernizr' );


        /**
         * Enqueue config / bespoke
         */
        wp_enqueue_script( 'mcd-js');

        // Conditional enqueue
        if ( is_front_page() ) {
            wp_enqueue_script( 'example-js');
        }
    }
}

// Enqueue CSS
if( !function_exists("mcd_theme_styles") ) {
    function mcd_theme_styles() {
        // Registering makes the scripts available to WordPress
        // http://codex.wordpress.org/Function_Reference/wp_register_script
        wp_register_style(
            'mcd',
            get_template_directory_uri() . '/assets/dist/css/style.min.css',
            array(),
            '1.0',
            'all'
        );
        wp_enqueue_style( 'mcd' );

        // Need to output the default `style.css` for child themes
        // No need to register as WordPress is already aware
        // See: http://codex.wordpress.org/Function_Reference/wp_enqueue_style
        //wp_enqueue_style( 'style', get_stylesheet_uri() );

        // Remove plugin CSS and incorporate into project
        // See: http://davidwalsh.name/remove-stylesheets
        //wp_dequeue_style('css-id');
    }
}


// Custom excerpt length (in words, default value = 55)
function mcd_excerpt_length($length) {
    return 55;
}

// Custom more link (see: https://codex.wordpress.org/Customizing_the_Read_More)
function mcd_excerpt_more($more) {
    global $post;
    return '&#8230; <a href="'. get_permalink($post->ID) . '" class="read-more">' . __( 'read more', 'mcd' ) . '&#x27a4;</a>';
}

// Disable jump in "read more" link
function mcd_remove_more_jump_link( $link ) {
    $offset = strpos($link, '#more-');
    if ( $offset ) {
        $end = strpos( $link, '"',$offset );
    }
    if ( $end ) {
        $link = substr_replace( $link, '', $offset, $end-$offset );
    }
    return $link;
}

// Remove `p` tags around inserted images
function filter_ptags_on_images($content) {
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// Add custom feed content
function mcd_add_feed_content($content) {
    if(is_feed()) {
        $content .= '<p>This article is copyright &copy; '.date('Y').'&nbsp;'.bloginfo('name').'</p>';
    }
    return $content;
}

// Delay feed update
function mcd_publish_later_on_feed($where) {
    global $wpdb;

    if (is_feed()) {
        // timestamp in WP-format
        $now = gmdate('Y-m-d H:i:s');

        // value for `wait`; + device
        $wait = '10'; // integer

        // http://dev.mysql.com/doc/refman/5.0/en/date-and-time-functions.html#function_timestampdiff
        $device = 'MINUTE'; // MINUTE, HOUR, DAY, WEEK, MONTH, YEAR

        // add SQL-syntax to default `$where`
        $where .= " AND TIMESTAMPDIFF($device, $wpdb->posts.post_date_gmt, '$now') > $wait ";
    }
    return $where;
}

// Remove height/width attributes on images so they can be responsive
function mcd_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}


/** ----------------------------------------------------------------------------------------
 * Login and admin customisations
 * -----------------------------------------------------------------------------------------
 */

// Custom admin login logo
// We have to use some inline CSS to override the default WordPress styles
function mcd_login_logo() {
    echo '<style type="text/css">
    .login h1 a {
        margin: 0 auto;
        padding-bottom: 0 !important;
        width: 144px !important;
        height: 144px !important;
        background-image: url('.get_template_directory_uri().'/assets/img/custom-login-logo.png) !important;
        background-size: auto !important;
    }
    .login form {
        background-color: #fff;
        border: none;
    }
    .login label {
        color: #000 !important
    }
    .login form input {
        border-color: #79c143 !important
    }
    .login form input.button-primary {
        background-color: #79c143;
        border: none !important;
    }

    .login form input.button-primary:hover,
    .login form input.button-primary:focus,
    .login form input.button-primary:active {
        background-color: #619d34;
    }
    </style>';
}

// Use your own external URL logo link
function mcd_url_login(){
    return "http://example.com/";
}

// The WordPress dashboard can be a bit cluttered, let's unset and tidy up
function mcd_dashboard_widgets() {
    global $wp_meta_boxes;

    // Main column
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);

    // Side Column
    //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

    wp_add_dashboard_widget('mcd_help_widget', 'Help and Support', 'mcd_dashboard_help');
}

function mcd_dashboard_help() {
   echo '<p>This is your website\'s admin area. Need help? <a href="mailto:support@example.com">Get in touch!</a></p>';
}

// Configure text editor controls to allowed actions
// See: https://codex.wordpress.org/TinyMCE
function change_mce_options( $opt ) {
    $opt['block_formats'] = "Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Pre=pre; Code=code";
    $opt['toolbar2'] = 'formatselect,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help ';
    return $opt;
}


/** -----------------------------------------------------------------------------
 * <head> customisations
 * ------------------------------------------------------------------------------
 */

// Remove functions from the `<head>` section
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
//remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'parent_post_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');


/** ----------------------------------------------------------------------------------------
 * Widget setup
 * -----------------------------------------------------------------------------------------
 * Implement a widget area into any template file using the following syntax
 *
 * <?php if ( is_active_sidebar( 'footer-widget-area' ) ) : ?>
 *      <?php dynamic_sidebar( 'footer-widget-area' ); ?>
 * <?php endif; ?>
 */

// Register widgetised area(s)
// See: http://codex.wordpress.org/Function_Reference/register_sidebar
function mcd_widgets_init() {

    // Main sidebar
    // Empty by default
    register_sidebar( array(
        'name' => __( 'Sidebar', 'mcd' ),
        'id' => 'main-sidebar',
        'description' => __( 'Customise the sidebar with widgets', 'mcd' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );

    // Sidebar for pages
    // The sidebar-page.php file includes a child/sibling listing
    register_sidebar( array(
        'name' => __( 'Pages Sidebar', 'mcd' ),
        'id' => 'pages-sidebar',
        'description' => __( 'Customise the pages sidebar with widgets', 'mcd' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );

    // Footer "Sidebar" widget area
    // @todo create a sidebar-footer.php
    register_sidebar( array(
        'name' => __( 'Footer Widget Area', 'mcd' ),
        'id' => 'footer-widget-area',
        'description' => __( 'Customise the global footer widget area with widgets', 'mcd' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );
}
