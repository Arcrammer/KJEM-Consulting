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
      if (!$_GET) {
        // The user isn't sorting or
        // anything. Just looking.
        $query = new WP_Query([
          // Audio should come first
          'post_type' => 'featured-video',
          'meta_key' => 'media_type',
          'orderby' => 'meta_value',
          'order' => 'ASC'
        ]);
      } else {
        // There's GET data, so the
        // user is probably sorting
        $query = new WP_Query([
          'post_type' => 'featured-video',
          'meta_key' => $_GET['sort_with'],
          'meta_value' => $_GET['of']
        ]);
      }

      while ($query->have_posts()):
        $query->the_post();

        $video = get_fields();
        $video += get_field('file');
        $video += [
          'url_without_ext' => preg_replace('/\\.[^.\\s]{3,4}$/', '', $video['url'])
        ];
      ?>
      <article class="featured-video">
        <a href="<?= get_the_permalink() ?>">
          <div class="overlay">
            <img class="play-icon" src="<?= get_template_directory_uri().'/assets/icons/Play.png' ?>" alt="Play icon" />
            <img src="<?= $video['url_without_ext'] ?>.jpg" alt="<?= $video['title'] ?>">
          </div> <!-- .overlay -->
        </a>
        <a href="<?= get_the_permalink() ?>">
          <div class="video-metadata">
              <h1><?= $video['song_title'] ?></h1>
              <p>Written by <?= $video['writers'] ?></p>
              <p class="pro_affiliation"><?= $video['pro_affiliation'] ?></p>
          </div> <!-- .video-metadata -->
        </a>
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
