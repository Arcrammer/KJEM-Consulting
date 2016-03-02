<?php
/**
  * Template Name: Featured Videos
  *
  * This is the template that displays all pages by default.
  * Please note that this is the WordPress construct of pages
  * and that other 'pages' on your WordPress site will use a
  * different template.
  *
  * @package freak
  */

  get_header();
?>

<div id="primary-mono" class="content-area <?php do_action('freak_primary-width') ?> page">
  <main id="main" class="site-main featured-videos" role="main">
    <h1 class="page-description">Some work by our writers.</h1>
    <?php
      // Just show the videos
      $query = new WP_Query('post_type=featured-video');
      while ($query->have_posts()):
        // Write the post to the response
        $query->the_post();

        $video = get_field('file');
        $video += get_fields();
        $video += [
          'url_without_ext' => preg_replace('/\\.[^.\\s]{3,4}$/', '', $video['url'])
        ];
      ?>
      <article class="featured-video">
        <div class="overlay">
          <a href="<?= get_the_permalink() ?>">
            <img class="play-icon" src="<?= get_template_directory_uri().'/assets/icons/Play.png' ?>" alt="Play icon" />
            <img src="<?= $video['url_without_ext'] ?>.jpg" alt="<?= $video['title'] ?>">
          </a>
        </div> <!-- .overlay -->
        <div class="video-metadata">
          <a href="<?= get_the_permalink() ?>">
            <h1><?= $video['song_title'] ?></h1>
            <p>Written by <?= $video['writers'] ?></p>
            <p class="pro_affiliation"><?= $video['pro_affiliation'] ?></p>
          </a>
        </div> <!-- .video-metadata -->
      </article>
      <?php
        // If comments are open or we have at least one comment, load up the comment template
        if (comments_open() || get_comments_number()) {
          comments_template();
        }
      endwhile
    ?>
  </main> <!-- #main -->
</div> <!-- #primary -->

<?php get_sidebar() ?>
<?php get_footer() ?>
