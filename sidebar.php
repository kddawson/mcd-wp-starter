<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package mcd
 */

if ( ! is_active_sidebar( 'main-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
	<?php dynamic_sidebar( 'main-sidebar' ); ?>
</aside>
