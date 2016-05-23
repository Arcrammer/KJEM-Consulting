<?php

function theme_enqueue_styles () {
  wp_dequeue_style('freak-main-theme-style');
  wp_deregister_style('freak-main-theme-style');

  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
  wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', ['parent-style']);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 20);

/**
 * Setting preferences through AJAX
 */
add_action('init', function () {
  if ($_GET['action'] == 'set_prefers_no_banner') {
    setcookie('prefers_no_banner', true);
    exit(var_dump($_COOKIE));
  }
});

/**
 * ACF Stuff
 */
function acf_save_post ($post_id) {
  if (get_post_type($post_id) == 'featured-video') {
    // Save a record for each tag
    $provided_moods = preg_split('/(?!\s)([\W\s]+)/', get_field('mood'));
    foreach ($provided_moods as $provided_mood) {
      add_post_meta($post_id, 'moods', $provided_mood);
    }

    // Determine whether the post is audio or video
    if (preg_match('/video/', get_field('file')['mime_type'])) {
      // We can assume it's video
      add_post_meta($post_id, 'media_type', 'video');
    } else {
      // We can assume it's audio
      add_post_meta($post_id, 'media_type', 'audio');
    }
  }
}
add_action('acf/save_post', 'acf_save_post', 20);

/**
 * Additional General Settings options
 */
 function bootstrap_custom_settings () {
   add_settings_field(
     'show_internships_banner',
     'Internships Banner',
     'show_internships_banner_callback',
     'general'
   );
   register_setting('general', 'show_internships_banner');
 }

add_action('admin_init', 'bootstrap_custom_settings');

function show_internships_banner_callback () {
  echo '<input id="show_internships_banner" name="show_internships_banner" type="checkbox" value="1"'.checked(1, get_option('show_internships_banner'), false).'><label for="show_internships_banner">Show</label>';
}

/**
 * Make WooCommerce shut up about the theme support
 */
function woocommerce_support () {
  add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'woocommerce_support');

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function freak_child_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'freak' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title title-font">',
		'after_title'   => '</h1>',
	) );
  register_sidebar( array(
		'name'          => __('Featured Videos Sidebar', 'freak'),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget widget_recent_entries %2$s">',
		'after_widget'  => '</aside> <!-- .featured-writers-sidebar -->',
		'before_title'  => '<h1 class="widget-title title-font">',
		'after_title'   => '</h1>',
	) );
  register_sidebar( array(
		'name'          => __('Press Releases Sidebar', 'freak'),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget widget_recent_entries %2$s">',
		'after_widget'  => '</aside> <!-- .press-releases-sidebar -->',
		'before_title'  => '<h1 class="widget-title title-font">',
		'after_title'   => '</h1>',
	) );
  register_sidebar( array(
		'name'          => __('About Sidebar', 'freak'),
		'id'            => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside> <!-- .widget %2$s -->',
		'before_title'  => '<h1 class="widget-title title-font">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'freak' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title title-font">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 2', 'freak' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title title-font">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 3', 'freak' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title title-font">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 4', 'freak' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title title-font">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'freak_child_widgets_init' );
