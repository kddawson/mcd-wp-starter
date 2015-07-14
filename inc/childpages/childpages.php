<?php
/**
 * Display child pages on parent page (or show siblings)
 * To use: <?php mcd_list_child_pages(); ?>
 *
 * @package mcd
 */

function mcd_list_child_pages() {

    global $post;

    if($post->post_parent) {
        $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
        $ancestortitle = get_the_title($post->post_parent);
    }

    else {
        $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
        $ancestortitle = get_the_title($post->ID);
    }
    if ($children) { ?>
        <h2 class="widgettitle current_page_ancestor"><?php echo $ancestortitle; ?></h2>
        <ul class="children">
            <?php echo $children; ?>
        </ul>
    <?php }
}

add_shortcode('mcd_childpages', 'mcd_list_child_pages');

?>
