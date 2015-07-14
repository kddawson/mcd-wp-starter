<?php
/**
 * @package mcd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
		<div class="entry-meta">
			<?php mcd_posted_on(); ?>
		</div>
	</header>
	<div class="entry-content" itemprop="text">
		<?php the_content(); ?>
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
