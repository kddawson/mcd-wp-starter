<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package mcd
 */

get_header(); ?>
	<main id="main" class="site-main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
	<?php if ( have_posts() ) : ?>
    <article class="entry">
		<header class="entry-header">
			<?php
				the_archive_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description" itemprop="description">', '</div>' );
			?>
		</header>
		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
				/* Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );
			?>
		<?php endwhile; ?>
	    <?php the_post_navigation(); ?>
    </article>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>
	</main>
    <?php get_sidebar(); ?>
<?php get_footer(); ?>
