<?php
/**
  * Template Name: Press Releases
  *
  * This is the template that displays all pages by default.
  * Please note that this is the WordPress construct of pages
  * and that other 'pages' on your WordPress site will use a
  * different template.
  *
  * @package freak
  */

  get_header();

  $currentPageNumber = array_pop(preg_split('@/@', $_SERVER['REQUEST_URI'], NULL, PREG_SPLIT_NO_EMPTY));
  $currentPageNumber = ($currentPageNumber == "press") ? 1 : $currentPageNumber;
?>

<div id="primary-mono" class="content-area <?php do_action('freak_primary-width') ?> page">
  <main id="main" class="site-main featured-videos" role="main">
    <h1 class="page-description">Press releases and media resources.</h1>
    <h4 class="page-description">If you’re looking for the latest events at KJEM, you’re at the right place! For enquiries contact Karen Jones at <em>(510) 493 - 3326</em> or send mail to <em>mediasupport@kjemconsulting.com</em>.</h4>
    <hr />
    <?php
      $query = new WP_Query('post_type=press-releases');
      while ($query->have_posts()):
    ?>
      <article class="press-release">
        <?php $query->the_post() ?>
        <p><a href="<?= get_the_permalink() ?>"><?= get_the_author() ?></a> posted on <?= get_the_date() ?></p>
        <h4><?= get_the_title() ?></h4>
        <?= get_the_content() ?>
        <a href="<?= get_the_permalink() ?>">Read More...</a>
      </article>
      <hr />
    <?php
      endwhile;

      // If comments are open or we have at least one comment, load up the comment template
      if (comments_open() || get_comments_number()) {
        comments_template();
      }
    ?>
    <?php if ($currentPageNumber > 1): ?>
      <a class="older-releases" href="/press/page/<?= $currentPageNumber - 1 ?>">Older Releases</a>
    <?php endif; if ($query->found_posts >= 10): ?>
      <a class="newer-releases" href="/press/page/<?= $currentPageNumber + 1 ?>">Newer Releases</a>
    <?php endif ?>
  </main> <!-- #main -->
</div> <!-- #primary -->

<?php get_sidebar() ?>
<?php get_footer() ?>
