<?php
/**
 * Template partial that is shortcode-enabled
 *
 * Usage: <?php kw_example(); ?> Shortcode: [kw_example]
 * @package kw
 */


function mcd_example( $atts, $content = null ) {
    extract = shortcode_atts( array(
        // For use in WP query or templating logic
        'attribute' => 'value',
    ), $atts );

    // buffer the output so the shortcode appears where you place it in the text editor
    ob_start();
?>

<!-- WP / markup here -->

<?php
    // output the buffer
    $output = ob_get_clean();
    return $output;
}
add_shortcode('kw_example', 'kw_example');


/*
 * Optionally, enqueue any JS specific to this partial
 */

wp_register_script(
    'kw-partial-ex-js',
    get_template_directory_uri() . '/inc/partials/partial-ex.js',
    array('jquery'),
    '1.0',
    true
);

wp_enqueue_script( 'kw-partial-ex-js' );

?>
