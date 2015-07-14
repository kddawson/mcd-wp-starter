<?php
/**
 * @package mcd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php mcd_posted_on(); ?>
		</div>
		<?php endif; ?>
	</header>
	<div class="entry-content" itemprop="text">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'mcd' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'mcd' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<footer class="entry-footer">
        <div class="entry-meta">
    		<?php mcd_entry_footer(); ?>
        </div>
	</footer>
</article>
