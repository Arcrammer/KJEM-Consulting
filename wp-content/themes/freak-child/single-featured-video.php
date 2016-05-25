<?php
/**
 * The template for single video pages
 * @package freak-child
 */

// Prepare the video array
$video = get_field('file');
$video += get_fields();
$video += [
  'url_without_ext' => preg_replace('/\\.[^.\\s]{3,4}$/', '', $video['url'])
];
// Load MediaElement
wp_enqueue_script('wp-mediaelement');
wp_enqueue_style('wp-mediaelement');
add_action('wp_footer', function () {
  echo '<script src="'.get_template_directory_uri().'/assets/scripts/featured-writers.js"></script>';
}, 20);
// 20 is the same level as enqueued scripts, so
// it comes after them which is important because
// MediaElement is enqueued
get_header(); ?>
  </div>
</div> <!--.mega-container-->
<header class="entry-header freak-single-entry-header">
  <div class="entry-header-bg" style="
    background-image: url(<?php $im = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
    echo $im[0]; ?>)
  ">
  </div> <!-- .entry-header-bg -->
  <div class="layer">
    <div class="container">
      <div class="entry-meta">
        <?php if (have_posts()): the_post() ?>
          <h1><?= get_field('song_title') ?></h1>
          <h4>Written by <?= get_field('writers') ?></h4>
          <h6><?= get_field('pro_affiliation') ?></h6>
        <?php rewind_posts(); endif ?>
      </div> <!-- .entry-meta -->
   </div> <!-- .container -->
 </div> <!-- .layer -->
</header> <!-- .entry-header .freak-single-entry-header -->
<div class="mega-container content mega-container-2">
  <div class="container content">
    <div id="primary-mono" class="content-area <?php do_action('freak_primary-width') ?>">
      <main id="main" class="site-main" role="main">
        <?php
          while (have_posts()):
            the_post();
            $is_video = preg_match('/video/', get_field('file')['mime_type']);
            if ($is_video): ?>
              <video width="320" height="240" poster="<?= $video['url_without_ext'] ?>.jpg" controls="controls" preload="none">
                <!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
                <source type="video/mp4" src="<?= $video['url_without_ext'] ?>.mp4" />
                <!-- WebM/VP8 for Firefox 4, Opera, and Chrome -->
                <source type="video/webm" src="<?= $video['url_without_ext'] ?>.webm" />
                <!-- Ogg/Vorbis for older Firefox and Opera versions -->
                <source type="video/ogg" src="<?= $video['url_without_ext'] ?>.ogv" />
                <!-- Flash fallback for non-HTML5 browsers without JavaScript -->
                <object width="320" height="240" type="application/x-shockwave-flash" data="flashmediaelement.swf">
                  <param name="movie" value="flashmediaelement.swf" />
                  <param name="flashvars" value="controls=true&file=<?= $video['url_without_ext'] ?>.mp4" />
                  <!-- Image as a last resort -->
                  <img src="<?= $video['url_without_ext'] ?>.jpg" width="320" height="240" title="No video playback capabilities" />
                </object>
              </video>
            <?php else: ?>
              <audio src="<?= $video['url'] ?>" type="<?= $video['mime_type'] ?>"></audio>
            <?php endif ?>
        <?php
          // If comments are open or we have at least one comment, load the comment template
          if (comments_open() || get_comments_number()) comments_template();
          endwhile
        ?>
      </main> <!-- #main .site-main -->
    </div> <!-- #primary-mono .content-area -->
<?php get_footer(); ?>
