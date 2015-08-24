<?php
/**
 * Template partial that is shortcode-enabled
 * See: https://codex.wordpress.org/Shortcode_API
 *
 * Usage: <?php mcd_example_func(); ?> Shortcode: [mcd_example]
 * @package mcd
 */


function mcd_example_func( $atts, $content = null ) {
    extract (shortcode_atts( array(
        // For use in WP query or templating logic
        'attribute' => 'value',
    ), $atts ) );

    // buffer the output so the shortcode appears where you place it in the text editor
    ob_start();

    // Optional: enqueue script only when sortcode is used
    wp_enqueue_script( 'mcd-partial-ex-js' );
?>

<!-- WP / markup here -->

<?php
    // output the buffer
    $output = ob_get_clean();
    return $output;
}
add_shortcode('mcd_example', 'mcd_example_func');


/*
 * Optional: register any JS specific to this partial
 */

wp_register_script(
    'mcd-partial-ex-js',
    get_template_directory_uri() . '/inc/partials/partial-ex.js',
    array('jquery'),
    '1.0',
    true
);

?>
