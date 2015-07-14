<?php
/**
 * The sidebar for the pages.
 *
 * @package mcd
 *
 */
?>

<aside id="secondary" class="widget-area" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
    <section class="widget parent-child-pagelist">
        <?php // inc/childpages/childpages.php  ?>
        <?php mcd_list_child_pages(); ?>
    </section>
    <?php dynamic_sidebar( 'pages-sidebar' ); ?>
</aside>
