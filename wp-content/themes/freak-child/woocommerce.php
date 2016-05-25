<?php
 /**
  * Woocommerce pages
  * @package freak-child
  */

get_header();

?>

<div id="primary-mono" class="content-area <?php do_action('freak_primary-width') ?> page">
  <main id="main" class="site-main" role="main">
    <?php woocommerce_content() ?>
  </main> <!-- #main -->
</div> <!-- #primary -->

 <?php get_sidebar(); ?>
 <?php get_footer(); ?>
