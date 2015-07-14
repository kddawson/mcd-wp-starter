<?php
/**
 * The template for displaying search results pages.
 *
 * @package mcd
 */

get_header(); ?>
	<main id="main" class="site-main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Blog">
	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<h1 class="page-title" itemprop="headline"><?php printf( __( 'Search Results for: %s', 'mcd' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		</header>
		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
			/**
			 * Run the loop for the search to output the results.
			 * If you want to overload this in a child theme then include a file
			 * called content-search.php and that will be used instead.
			 */
			get_template_part( 'template-parts/content', 'search' );
			?>
		<?php endwhile; ?>
		<?php the_post_navigation(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>
	</main>
    <?php get_sidebar(); ?>
<?php get_footer(); ?>
