<?php
/**
 * Custom comments incorporating http://schema.org/UserComments
 *
 * @package mcd
 */


// Template for comments and pingbacks
if ( ! function_exists( 'mcd_comment' ) ) :

function mcd_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case '' :
    ?>
    <li <?php comment_class(); ?>>
        <article id="comment-<?php comment_ID(); ?>" itemscope itemprop="comment" itemtype="http://schema.org/UserComments">
            <header class="comment-header">
                <div class="comment-meta commentmetadata">
                    <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                    <?php /* translators: 1: date, 2: time */ printf( __( '<time itemprop="commentTime" datetime="%1$s">%1$s at %2$s</time>', 'mcd' ), get_comment_date(),  get_comment_time() ); ?>
                    </a>
                    <?php printf( __( '%s <span class="says">says:</span>', 'mcd' ), sprintf( '<cite class="fn" itemprop="creator">%s</cite>', get_comment_author_link() ) ); ?>
                </div>
            </header>
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <p><em><?php _e( 'Your comment is awaiting moderation.', 'mcd' ); ?></em></p>
            <?php endif; ?>
            <div class="comment-content cf">
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment, 64 ); ?>
                </div>
                <div class="comment-body" content="<?php the_title() ?>" itemprop="discusses">
                    <?php comment_text(); ?>
                </div>
            </div>
            <footer class="comment-reply">
                <?php edit_comment_link( __( '<i class="fa fa-pencil" aria-hidden="true"></i> Edit', 'mcd' ), ' ' ); ?>
                <?php delete_comment_link(get_comment_ID()); ?>
                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </footer>
        </article>
<?php
    break;
    case 'pingback'  :
    case 'trackback' :
?>
    <li class="comment pingback">
    <article>
        <p><?php _e( 'Pingback:', 'mcd' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('<i class="fa fa-pencil" aria-hidden="true"></i> Edit', 'mcd'), ' ' ); ?></p>
    </article>
<?php
    break;
    endswitch;
}
endif;

// Enable threaded comments
function enable_threaded_comments(){
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
            wp_enqueue_script('comment-reply');
    }
}
add_action('get_header', 'enable_threaded_comments');


// Removes the default styles that are packaged with the Recent Comments widget
function mcd_remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}


// Remove nofollow from comments
function xwp_dofollow($str) {
    $str = preg_replace(
        '~<a ([^>]*)\s*(["|\']{1}\w*)\s*nofollow([^>]*)>~U',
        '<a ${1}${2}${3}>', $str);
    return str_replace(array(' rel=""', " rel=''"), '', $str);
}
// We have spam protection, so let's thank comment authors
remove_filter('pre_comment_content', 'wp_rel_nofollow');
add_filter('get_comment_author_link', 'xwp_dofollow');
add_filter('post_comments_link', 'xwp_dofollow');
add_filter('comment_reply_link', 'xwp_dofollow');
add_filter('comment_text', 'xwp_dofollow');


// Spam & delete links for all versions of WordPress
/** add <?php delete_comment_link(get_comment_ID()); ?> to comments functionality */
function delete_comment_link($id) {
    if (current_user_can('edit_post')) {
        echo '<a href="'.site_url().'/wp-admin/comment.php?action=cdc&amp;c='.$id.'" class="btn btn-default btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a> ';
        echo '<a href="'.site_url().'/wp-admin/comment.php?action=cdc&amp;dt=spam&amp;c='.$id.'" class="btn btn-default btn-sm"><i class="fa fa-ban" aria-hidden="true"></i> Mark as Spam</a>';
    }
}


// Escape html entities in comments
// Wrap code in <code> tags without having to write &lt; and &gt; ad infinitum
function encode_code_in_comment($source) {
    $encoded = preg_replace_callback('/<code>(.*?)<\/code>/ims',
    create_function('$matches', '$matches[1] = preg_replace(array("/^[\r|\n]+/i", "/[\r|\n]+$/i"), "", $matches[1]);
    return "<code>" . htmlentities($matches[1]) . "</"."code>";'), $source);
    if ($encoded)
        return $encoded;
    else
        return $source;
}
add_filter('pre_comment_content', 'encode_code_in_comment');
