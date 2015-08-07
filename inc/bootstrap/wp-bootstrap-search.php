<?php
/**
 * The template for displaying the search form using Twitter Bootstrap (copy to searchform.php)
 *
 */
?>


<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
    <div class="input-group">
        <label for="s" class="sr-only"><?php _e( 'Search', 'mcd' ); ?></label>
        <input type="search" id="s" name="s" results="5" autocomplete="on" placeholder="<?php esc_attr_e( 'Search&#8230;', 'mcd' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" class="form-control">
        <span class="input-group-btn">
            <button type="submit" id="searchsubmit" class="btn btn-primary"><?php esc_attr_e( 'Search', 'mcd' ); ?></button>
        </span>
    </div>
</form>
