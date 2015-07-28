<?php
/**
 * WP snippets for cut 'n' paste
 *
 */
?>

<?php
    $someLoop = new WP_Query(
        array(
            'post_type' => 'cpt',
            'posts_per_page' => 3,
            'post__not_in' => array( $post->ID )
        )
    );
?>


<?php while ( $someLoop->have_posts() ) : $someLoop->the_post(); ?>
    <!-- do some stuff -->
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>


<?php
    global $post;
    $temp = $wp_query;
    $wp_query = null;
    $wp_query = new WP_Query();

    $args = array(
        'meta_query' => array(
            array(
                'key' => 'some-key',
                'value' => '1',
                'compare' => '=='
            )
        ),
        'post_status' => 'publish',
        'post_type'   => 'cpt',
    );

    $myposts = get_posts( $args );

    foreach( $myposts as $post ) :  setup_postdata($post); ?>
        <!-- do some stuff -->
    <?php endforeach; ?>
    <?php
        $wp_query = null;
        $wp_query = $temp;  // Reset the query loop
?>


<?php
    $showCategory = new WP_Query();
    $showCategory->query(
        array(
            'showposts' => 2,
            'cat' => 121
        )
    );
?>


<?php while ($showCategory->have_posts()) : $showCategory->the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_post_thumbnail('some-thumbnail'); ?>
        <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h2>
        <div class="entry-meta">
            <time class="entry-date" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('d/m/y'); ?></time>
        </div>
    </header>
    <div class="entry-summary">
        <?php the_content(); ?>
    </div>
</article>
<?php endwhile; ?>
<?php wp_reset_postdata(); ?>


<?php
/**
 * Use an Advanced Custom Fields image (set to return the Image ID) with RICG Responsive Images
 *
 */
?>
<?php

    $acf_image = get_field('acf_custom_image');
    $size = 'medium'; // (thumbnail, medium, large, full or custom size)

    if( $acf_image ) {
        echo wp_get_attachment_image( $acf_image, $size );
    }

?>
