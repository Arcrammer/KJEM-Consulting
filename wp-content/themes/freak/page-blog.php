<?php
/**
 * Template Name: Blog
 *
 * This is the template used for
 * the personal blog at /blog
 *
 * @package freak
 */

$query = new WP_Query('post_type=blog');

get_header(); ?>

	<div id="primary-mono" class="content-area <?php do_action('freak_primary-width') ?> page">
		<main id="main" class="site-main" role="main">

			<?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
