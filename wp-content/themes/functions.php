<?php
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
 * freak functions and definitions
 *
 * @package freak
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'freak_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function freak_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on freak, use a find and replace
	 * to change 'freak' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'freak', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 *
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'freak' ),
		'static' => __( 'Static Bar Menu', 'freak' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'freak_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_image_size('freak-slider-thumb', 542,341, true );
	add_image_size('freak-pop-thumb',542, 340, true );
	add_image_size('freak-thumb',542, 410, true );
}
endif; // freak_setup
add_action( 'after_setup_theme', 'freak_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function freak_widgets_init() {
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
add_action( 'widgets_init', 'freak_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function freak_scripts() {
	wp_enqueue_style( 'freak-style', get_stylesheet_uri() );

	wp_enqueue_style('freak-title-font', '//fonts.googleapis.com/css?family='.str_replace(" ", "+", get_theme_mod('freak_title_font', 'Bitter') ).':100,300,400,700' );

	wp_enqueue_style('freak-body-font', '//fonts.googleapis.com/css?family='.str_replace(" ", "+", get_theme_mod('freak_body_font', 'Roboto Slab') ).':100,300,400,700' );

	wp_enqueue_style( 'freak-fontawesome-style', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css' );

	wp_enqueue_style( 'freak-nivo-style', get_template_directory_uri() . '/assets/css/nivo-slider.css' );

	wp_enqueue_style( 'freak-nivo-skin-style', get_template_directory_uri() . '/assets/css/nivo-default/default.css' );

	wp_enqueue_style( 'freak-bootstrap-style', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css' );

	wp_enqueue_style( 'freak-hover-style', get_template_directory_uri() . '/assets/css/hover.min.css' );

	wp_enqueue_style( 'freak-slicknav', get_template_directory_uri() . '/assets/css/slicknav.css' );

	wp_enqueue_style( 'freak-fleximage-style', get_template_directory_uri() . '/assets/css/jquery.flex-images.css' );

	wp_enqueue_style( 'freak-main-theme-style', get_template_directory_uri() . '/assets/css/main.css' );

	wp_enqueue_script( 'freak-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'freak-externaljs', get_template_directory_uri() . '/js/external.js', array('jquery') );

	wp_enqueue_script( 'freak-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'freak-custom-js', get_template_directory_uri() . '/js/custom.js', array(), 1, true );
}
add_action( 'wp_enqueue_scripts', 'freak_scripts' );

/**
 * Enqueue Scripts for Admin
 */
function freak_custom_wp_admin_style() {
        wp_enqueue_style( 'freak-admin_css', get_template_directory_uri() . '/assets/css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'freak_custom_wp_admin_style' );


function freak_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'freak_excerpt_more');

/**
 * Include the Custom Functions of the Theme.
 */
require get_template_directory() . '/framework/theme-functions.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Implement the Custom CSS Mods.
 */
require get_template_directory() . '/inc/css-mods.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Import custom widgets
 */
require get_template_directory().'/inc/widgets.php';
