<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mcd
 */
?>

<article class="entry no-results not-found" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
	<header class="entry-header">
		<h1 class="entry-title" itemprop="headline"><?php _e( 'Nothing Found', 'mcd' ); ?></h1>
	</header>
	<div class="entry-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'mcd' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
		<?php elseif ( is_search() ) : ?>
			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mcd' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mcd' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</article>
