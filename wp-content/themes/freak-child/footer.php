<?php
/**
 * The template for displaying the footer
 * @package freak-child
 */
?>
    <!-- #content -->
    <?php get_sidebar('footer'); ?>
    <footer id="colophon" class="site-footer" role="contentinfo">
      <div class="site-info container">
        <?php
          if (get_theme_mod('freak_footer_text') == '') {
            echo ('&copy; '.date('Y'). ' '.get_bloginfo('name').__('. All Rights Reserved. ', 'freak'));
          } else {
            esc_html(get_theme_mod('freak_footer_text'));
          }
        ?>
    </footer> <!-- #colophon -->
    </div> <!-- #page -->
    <!-- Scripts -->
    <script src="<?= get_stylesheet_directory_uri().'/assets/scripts/main.js' ?>"></script>

    <!-- Everything Else -->
    <?php wp_footer(); ?>
  </body>
</html>
