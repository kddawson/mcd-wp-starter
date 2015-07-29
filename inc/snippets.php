<?php
/**
 * WP snippets for cut 'n' paste
 *
 */
?>


<?php
/**
 * Default loop
 */
?>

<?php
    if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php // do some stuff ?>
    <?php endwhile; ?>
        <?php // do something once ?>
    <?php else : ?>
        <?php // do something different ?>
    <?php endif;
?>


<?php
/**
 * Loop with query_posts() example 1
 * Modify the default loop
 * Use to modify a single loop
 */
?>

<?php
    global $query_string; // required
    $posts = query_posts($query_string.'&cat=-9'); // exclude category 9 ?>
        <?php // default loop goes here ?>
    <?php wp_reset_query(); // reset the query
?>


<?php
/**
 * Loop with query_posts() example 2
 * Override the default loop by only sending the parameters you define
 * Use to modify a single loop
 */
?>

<?php
    global $query_string;
    $posts = query_posts('&cat=-9'); // $query_string omitted ?>
        <?php // default loop goes here ?>
    <?php wp_reset_query();
?>


<?php
/**
 * Loop with get_posts()
 * Use to display multiple, _static_ sets of content
 */
?>

<?php
    global $post; // required
    $args = array(
        'category' => -9
    );
    $custom_posts = get_posts($args);
    foreach($custom_posts as $post) : setup_postdata($post); ?>
        <?php // do some stuff ?>
    <?php endforeach;
?>


<?php
/**
 * Loop with WP_Query()
 * For complete control of the customisation of multiple loops in a theme template
 */
?>

<?php
    // Loop 1
    $first_query = new WP_Query('cat=-1,9&order=ASC');
    while($first_query->have_posts()) : $first_query->the_post(); ?>
        <?php // do some stuff ?>
    <?php endwhile;
    wp_reset_postdata();

    // Loop 2 (using an array for the query parameters)
    $second_query = new WP_Query(
        array(
            'post_type' => 'cpt',
            'posts_per_page' => 3
        )
    );
    while($second_query->have_posts()) : $second_query->the_post(); ?>
        <?php // do some stuff ?>
    <?php endwhile;
    wp_reset_postdata();
?>


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
