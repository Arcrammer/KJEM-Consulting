<?php
/**
 * @package Freak
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-12 col-sm-12 grid freak'); ?>>

			<?php if (has_post_thumbnail()) : ?>
        <div class="featured-thumb col-md-5 col-sm-4">
  				<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
            <?php the_post_thumbnail('freak-thumb'); ?>
          </a>
          <div class="postedon">
    				<div class="date"><?php echo get_the_date('M j'); ?></div>
    				<div class="author"><?php the_author_posts_link() ?></div>
    			</div>
    		</div><!--.featured-thumb-->
			<?php else: ?>
        <div class="no-thumb col-md-12 col-sm-12">
  				<!-- <a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
            <img src="<?php echo get_template_directory_uri()."/assets/images/placeholder2.jpg"; ?>">
          </a> -->
          <div class="postedon">
      				<?= the_author_posts_link().' posted '.get_the_date('M j, Y') ?>
    			</div>
    		</div>
			<?php endif; ?>

    <?php if (has_post_thumbnail()) : ?>
  		<div class="out-thumb col-md-7 col-sm-8">
    <?php else: ?>
      <div class="out-thumb col-md-12 col-sm-12">
    <?php endif ?>
			<header class="entry-header">
				<h1 class="entry-title title-font"><a class="hvr-underline-reveal" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<span class="entry-excerpt"><?php the_excerpt(); ?></span>
				<span class="readmore"><a class="hvr-underline-from-center" href="<?php the_permalink() ?>"><?php _e('Read More','freak'); ?></a></span>
			</header><!-- .entry-header -->
		</div><!--.out-thumb-->



</article><!-- #post-## -->
