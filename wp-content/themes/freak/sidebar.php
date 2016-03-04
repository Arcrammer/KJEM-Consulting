<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package freak
 */

// if ( ! is_active_sidebar( 'sidebar-1' ) ) {
// 	return;
// }

if (is_active_sidebar('sidebar-1')
    || is_active_sidebar('sidebar-2')
    || is_active_sidebar('sidebar-3')):
  if (is_active_sidebar('sidebar-1')
      && !is_page('featured-videos')
      && !is_page('press')):
    if (freak_load_sidebar()): ?>
      <div id="secondary" class="widget-area <?php do_action('freak_secondary-width') ?>" role="complementary">
      	<?php dynamic_sidebar( 'sidebar-1' ); ?>
      </div> <!-- #secondary -->
    <?php
    endif;
  endif;

  if (is_active_sidebar('sidebar-2') && is_page('featured-videos')):
    if (freak_load_sidebar()): ?>
      <div id="secondary" class="widget-area <?php do_action('freak_secondary-width') ?>" role="complementary">
        <?php dynamic_sidebar('sidebar-2'); ?>
      </div> <!-- #secondary -->
    <?php
    endif;
  endif;

  if (is_active_sidebar('sidebar-3') && is_page('press')):
    if (freak_load_sidebar()): ?>
      <div id="secondary" class="widget-area <?php do_action('freak_secondary-width') ?>" role="complementary">
        <?php dynamic_sidebar('sidebar-3'); ?>
      </div> <!-- #secondary -->
    <?php
    endif;
  endif;
endif;
