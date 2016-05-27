<?php
/**
 * @package freak-child
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <div class="entry-content">
    <?php
      the_post_thumbnail('full');
      the_content();
      wp_link_pages([
        'before' => '<div class="page-links">' . __( 'Pages:', 'freak' ),
        'after'  => '</div>'
      ]);
    ?>
  </div> <!-- .entry-content -->

  <footer class="entry-footer">
    <?php freak_entry_footer(); ?>
  </footer> <!-- .entry-footer -->
</article> <!-- #post-## -->
