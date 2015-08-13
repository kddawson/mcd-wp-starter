<?php
/**
 * The template for displaying the search form
 *
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
    <label for="s"><?php _e( 'Search', 'mcd' ); ?></label>
    <input type="search" id="s" name="s" class="search-query" autocomplete="on" placeholder="<?php esc_attr_e( 'Search&#8230;', 'mcd' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
    <input type="submit" id="searchsubmit" name="submit" value="<?php esc_attr_e( 'Search', 'mcd' ); ?>">
</form>
