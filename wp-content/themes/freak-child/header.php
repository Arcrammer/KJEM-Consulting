<?php
  /**
   * Displays all of the <head> section and everything up 'til <div id="content">
   * @package freak-child
   */
session_start();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <!-- Metadata -->
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">


    <!-- Links -->
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <!-- Everything Else -->
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <nav id="mobile-static-menu">
      <?php wp_nav_menu( array('theme_location' => 'static') ); ?>
    </nav>
    <?php if ( !get_theme_mod('freak_disable_static_bar_mobile') ) : ?>
    <div class="mobile-toggle-bar">
      <button class="mobile-toggle-button"><i class="fa fa-bars"></i></button>
    </div> <!-- .mobile-toggle-bar -->
    <?php endif; ?>
    <div id="page" class="hfeed site">
    <a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'freak'); ?></a>
    <div id="jumbosearch">
      <span class="fa fa-remove closeicon"></span>
      <div class="form">
        <?php get_search_form(); ?>
      </div>
    </div>
    <header id="masthead" class="site-header <?php do_action('freak_header_class'); ?>" role="banner" <?php do_action('freak_parallax_options'); ?>>
      <div class="layer">
        <div class="container">
          <div class="site-branding col-md-12">
            <?php if ( get_theme_mod('freak_logo') != "" ) : ?>
            <div id="site-logo">
              <a href="<?php echo esc_url( home_url('/') ); ?>"><img src="<?php echo esc_url( get_theme_mod('freak_logo') ); ?>"></a>
            </div>
            <?php endif; ?>
            <div id="text-title-desc">
              <h1 class="site-title title-font"><a href="<?php echo esc_url( home_url('/') ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
              <h2 class="site-description"><?php bloginfo('description'); ?></h2>
            </div>
          </div>
          <div class="social-icons col-md-12">
            <?php get_template_part('social', 'sociocon'); ?>
          </div>
          <?php if ( !get_theme_mod('freak_topsearch_disable', false) ) : ?>
          <div class="top-search col-md-12">
            <?php get_search_form(); ?>
          </div>
          <?php endif; ?>
        </div>
        <!--container-->
        <div id="top-bar">
          <div class="container">
            <nav id="top-menu">
              <?php wp_nav_menu( array('theme_location' => 'primary') ); ?>
            </nav>
          </div>
        </div>
      </div>
    </header>
    <!-- #masthead -->
    <?php get_template_part('slider', 'nivo'); ?>
    <?php get_template_part('featured', 'posts'); ?>
    <div class="mega-container mega-container-1">
    <div id="content" class="site-content container">
