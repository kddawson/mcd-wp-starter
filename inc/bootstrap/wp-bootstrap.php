<?php
/**
 * Plugin Name: Twitter Bootstrap Plugin
 * Description: Integrates the Twitter Bootstrap framework into WordPress - just add class
 * Version: 3.3.6 - Keep in sync with the corresponding release of Twitter Bootstrap
 * License: GPL
 * Author: Karl Dawson
 * Author URI: http://multicelldesign.com
 *
 */


/*
<div class="navbar navbar-default">
    <div class="container">
     <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-responsive-collapse" aria-expanded="false">
             <span class="sr-only">Toggle navigation</span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" title="<?php echo get_bloginfo('description'); ?>" href="/">
             brand
         </a>
     </div>
     <nav class="collapse navbar-collapse" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
         <?php wp_bootstrap_nav_menu(); // Adjust using Menus in Wordpress Admin ?>
         <?php //} ?>
     </nav>
    </div>
</div>
*/




/** -----------------------------------------------------------------------------
 * Modify the WordPress menu system to output as Twitter Bootstrap
 * ------------------------------------------------------------------------------
 */

class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {

    function start_el(&$output, $object, $depth = 0, $args = Array(), $current_object_id = 0){

        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        // If the item has children, add the dropdown class for bootstrap
        if ( $args->has_children ) {
            $class_names = "dropdown ";
        }

        $classes = empty( $object->classes ) ? array() : (array) $object->classes;

        // Modify WordPress classes output on li items
        // Other current classes: 'current_page_item', 'current_page_parent'
        $menu_item_classes = array('menu-item', 'current-menu-item', 'current-menu-parent');
        $newClasses = array();

        foreach($classes as $el){
                //check if it's indicating the current page or .menu-item, otherwise we don't need the class
                if (in_array($el, $menu_item_classes)){
                        array_push($newClasses, $el);
                }
        }
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $newClasses), $object ) );
        if($class_names!='') $class_names = ' class="'. esc_attr( $class_names ) . '"';
        // end class output modification

        // Original
        //$class_names .= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object ) );
        //$class_names = ' class="'. esc_attr( $class_names ) . '"';

        $output .= $indent . '<li id="menu-item-'. $object->ID . '"' . $value . $class_names .'>';

        $attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
        $attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
        $attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
        $attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';

        // if the item has children add these additional attributes to the anchor tag
        if ( $args->has_children ) {
          $attributes .= ' class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"';
        }

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before .apply_filters( 'the_title', $object->title, $object->ID );
        $item_output .= $args->link_after;

        // if the item has children add the caret just before closing the anchor tag
        if ( $args->has_children ) {
            $item_output .= '<b class="caret"></b></a>';
        }
        else {
            $item_output .= '</a>';
        }

        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $object, $depth, $args );
    }

    function start_lvl(&$output, $depth = 0, $args = Array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
}


// Add .active class to current menu item
function wp_bootstrap_add_active_class($classes, $item) {
    if( $item->menu_item_parent == 0 && in_array('current-menu-item', $classes) ) {
        $classes[] = "active";
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'wp_bootstrap_add_active_class', 10, 2 );


/** -----------------------------------------------------------------------------
 * Main navigation bar customization
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 * ------------------------------------------------------------------------------
 */

function mcd_page_menu_args( $args ) {
  $args['show_home'] = true;
  return $args;
}
add_filter( 'wp_page_menu_args', 'mcd_page_menu_args' );


// A custom walker class changes the default output of wp_nav_menu()
//require( get_template_directory() . '/inc/bootstrap/class-walker-nav-menu.php' );

function wp_bootstrap_nav_menu() {
    // display the wp menu if available
    wp_nav_menu (
        array (
            'menu'           => 'main_nav', /* menu name */
            'menu_class'     => 'nav navbar-nav',
            'theme_location' => 'primary', /* where in the theme it's assigned */
            'container'      => 'false', /* container class */
            'fallback_cb'    => 'mcd_nav_fallback', /* menu fallback */
            'depth'          => '2', /* suppress lower levels for now */
            'walker'         => new Bootstrap_Walker_Nav_Menu()
        )
    );
}


/** -----------------------------------------------------------------------------
 * Bootstrap pagination
 *
    <?php if (function_exists('wp_bootstrap_page_navi')) { ?>
        <?php wp_bootstrap_page_navi(); // use the page navi function ?>
    <?php } else { // if it is disabled, display regular wp prev & next links ?>
        <nav class="wp-prev-next">
            <ul class="pager">
                <li class="previous"><?php next_posts_link(_e('&laquo; Older Entries', 'mcd')) ?></li>
                <li class="next"><?php previous_posts_link(_e('Newer Entries &raquo;', 'mcd')) ?></li>
            </ul>
        </nav>
    <?php } ?>
 * ------------------------------------------------------------------------------
 */

function wp_bootstrap_page_navi($before = '', $after = '') {
    global $wpdb, $wp_query;
    $request = $wp_query->request;
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $paged = intval(get_query_var('paged'));
    $numposts = $wp_query->found_posts;
    $max_page = $wp_query->max_num_pages;
    if ( $numposts <= $posts_per_page ) { return; }
    if(empty($paged) || $paged == 0) {
        $paged = 1;
    }
    $pages_to_show = 7;
    $pages_to_show_minus_1 = $pages_to_show-1;
    $half_page_start = floor($pages_to_show_minus_1/2);
    $half_page_end = ceil($pages_to_show_minus_1/2);
    $start_page = $paged - $half_page_start;
    if($start_page <= 0) {
        $start_page = 1;
    }
    $end_page = $paged + $half_page_end;
    if(($end_page - $start_page) != $pages_to_show_minus_1) {
        $end_page = $start_page + $pages_to_show_minus_1;
    }
    if($end_page > $max_page) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = $max_page;
    }
    if($start_page <= 0) {
        $start_page = 1;
    }

    echo $before.'<ul class="pagination">'."";
    if ($paged > 1) {
        $first_page_text = "&laquo";
    echo '<li class="first-page"><a href="'.get_pagenum_link().'" aria-label="' . __('First','mcd') . '"><span aria-hidden="true">'.$first_page_text.'</span></a></li>';
    }

    $prevposts = get_previous_posts_link( __('&larr; Previous','mcd') );
    if($prevposts) { echo '<li>' . $prevposts  . '</li>'; }
    else { echo '<li class="disabled"><span><span aria-hidden="true">' . __('&larr; Previous','mcd') . '</span></span></li>'; }

    for($i = $start_page; $i  <= $end_page; $i++) {
        if($i == $paged) {
            echo '<li class="active"><span>'.$i.'<span class="sr-only">' . __('Current page','mcd') . '</span></span></li>';
        } else {
            echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
        }
    }
    echo '<li class="">';
    next_posts_link( __('Next &rarr;','mcd') );
    echo '</li>';
    if ($end_page < $max_page) {
        $last_page_text = "&raquo;";
        echo '<li class="last-page"><a href="'.get_pagenum_link($max_page).'" aria-label="' . __('Last','mcd') . '"><span aria-hidden="true">'.$last_page_text.'</span></a></li>';
    }
    echo '</ul>'.$after."";
}


/** -----------------------------------------------------------------------------
 * Add lead class to first paragraph
 * ------------------------------------------------------------------------------
 */

function wp_bootstrap_first_paragraph( $content ){
    global $post;

    // if we're on the homepage, don't add the lead class to the first paragraph of text
    if( is_page_template( 'front-page.php' ) )
        return $content;
    else
        return preg_replace('/<p([^>]+)?>/', '<p$1 class="lead">', $content, 1);
}
add_filter( 'the_content', 'wp_bootstrap_first_paragraph' );


/** -----------------------------------------------------------------------------
 * Add thumbnail class to thumbnail links
 * ------------------------------------------------------------------------------
 */

function wp_bootstrap_add_class_attachment_link( $html ) {
    $postid = get_the_ID();
    $html = str_replace( '<a','<a class="thumbnail"',$html );
    return $html;
}
add_filter( 'wp_get_attachment_link', 'wp_bootstrap_add_class_attachment_link', 10, 1 );


/** -----------------------------------------------------------------------------
 * Load Twitter Bootstrap JavaScript
 * ------------------------------------------------------------------------------
 */

if( !function_exists( "wp_bootstrap_js" ) ) {
    function wp_bootstrap_js() {

        // Registering makes the scripts available to WordPress
        // If not using a subset of Bootstrap scripts, register a CDN version...
        wp_register_script(
            'bootstrap-js',
            get_template_directory_uri() . '/bower_components/bootstrap/dist/js/bootstrap.min.js',
            array('jquery'),
            '3.3.2',
            true
        );

        // Enqueueing adds the script to the front-end (can be done conditionally in templates too)
        wp_enqueue_script('bootstrap-js');
    }
}
add_action('wp_enqueue_scripts', 'wp_bootstrap_js');
