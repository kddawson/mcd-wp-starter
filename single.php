<?php
/**
 * The template for displaying all single posts.
 *
 * @package mcd
 */

get_header(); ?>
	<main id="main" class="site-main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/content', 'single' ); ?>
		<?php the_post_navigation(); ?>
		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		?>
	<?php endwhile; // end of the loop. ?>
	</main>
    <?php get_sidebar(); ?>
<?php get_footer(); ?>
