<?php

class SortWidget extends WP_Widget {
  function __construct() {
    parent::__construct('SortWidget', 'Sort Featured Videos', [
      'description' => __('Sort featured videos by custom fields (or should I say \'supports\')', 'SortWidget_domain')
    ]);
  }

  /**
   * Front-end output
   *
   * @param array $args
	 * @param array $instance
   */
  public function widget($args, $instance) {
    global $wpdb;

    $title = apply_filters('widget_title', $instance['title']);
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];

    if (!empty($title)) echo $args['before_title'].$title.$args['after_title'];
    // This is where you run the code and display the output
    $videoProperties = [
      'Writers' => $wpdb
      ->get_results('SELECT "writers" AS property_name, meta_value
                     FROM wp_postmeta
                     WHERE meta_key="writers"
                     GROUP BY meta_value'),
      'Title' => $wpdb
      ->get_results('SELECT "song_title" AS property_name, meta_value
                     FROM wp_postmeta
                     WHERE meta_key="song_title"
                     GROUP BY meta_value'),
      'Publishers' => $wpdb
      ->get_results('SELECT "publishing_companies" AS property_name, meta_value
                     FROM wp_postmeta
                     WHERE meta_key="publishing_companies"
                     GROUP BY meta_value'),
      'Genre' => $wpdb
      ->get_results('SELECT "genre" AS property_name, meta_value
                     FROM wp_postmeta
                     WHERE meta_key="genre"
                     GROUP BY meta_value'),
      'Mood' => $wpdb
      ->get_results('SELECT "moods" AS property_name, meta_value
                     FROM wp_postmeta
                     WHERE meta_key="moods"
                     GROUP BY meta_value'),
      'Copyright' => $wpdb
      ->get_results('SELECT "copyright_protection" AS property_name, meta_value
                     FROM wp_postmeta
                     WHERE meta_key="copyright_protection"
                     GROUP BY meta_value'),
      'P.R.O.' => $wpdb
      ->get_results('SELECT "pro_affiliation" AS property_name, meta_value
                     FROM wp_postmeta
                     WHERE meta_key="pro_affiliation"
                     GROUP BY meta_value')
    ]; ?>
      <ul>
      <?php foreach ($videoProperties as $name => $available): ?>
          <li><?= $name ?></li>
          <ul>
            <?php foreach ($available as $a): ?>
              <?php if (!empty($a->property_name) && !empty($a->meta_value)): ?>
                <a href="?sort_with=<?= $a->property_name ?>&of=<?= $a->meta_value ?>">
                  <li><?= $a->meta_value ?></li>
                </a>
              <?php endif ?>
            <?php endforeach ?>
          </ul>
      <?php endforeach ?>
      </ul>
    <?php
    echo $args['after_widget'];
  }

  /**
   * Options form front-end output for the admin area
   *
   * @param array $instance Widget options
   */
  public function form($instance) {
    if (isset($instance['title'])) {
      $title = $instance['title'];
    } else {
      $title = __('Sort Featured Videos', 'SortWidget_domain');
    }

    // Widget admin form
    ?>
      <p>
        <label for="<?= $this->get_field_id('title') ?>">
          <?php _e('Title:') ?>
        </label>
        <input class="widefat" id="<?= $this->get_field_id('title') ?>" name="<?= $this->get_field_name('title') ?>" type="text" value="<?= esc_attr($title) ?>" />
      </p>
    <?php
	}

  /**
   * Process widget options when saved
   *
   * @param array $new_instance The new options
	 * @param array $old_instance The previous options
   */
  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']):
   '';
    return $instance;
  }
}

class RecentPressReleases extends WP_Widget {
  function __construct() {
    parent::__construct('RecentPressReleases', 'Recent Press Releases', [
      'description' => __('Recent Posts, but for Press Releases', 'RecentPressReleases_domain')
    ]);
  }

  /**
   * Front-end output
   *
   * @param array $args
	 * @param array $instance
   */
  public function widget($args, $instance) {
    global $wpdb;

    $title = apply_filters('widget_title', $instance['title']);
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];

    if (!empty($title)) echo $args['before_title'].$title.$args['after_title'];

    // Get the most recent post titles
    $fiveRecentReleases = $wpdb->get_results('SELECT * FROM wp_posts
                        WHERE post_type="press-releases"
                        LIMIT 5');

    // This is where you run the code and display the output ?>
    <ul>
      <?php foreach ($fiveRecentReleases as $recentRelease): ?>
        <li>
          <a href="<?= get_permalink($recentRelease->ID) ?>"><?= $recentRelease->post_title ?></a>
        </li>
      <?php endforeach ?>
    </ul>
    <?php
    echo $args['after_widget'];
  }

  /**
   * Options form front-end output for the admin area
   *
   * @param array $instance Widget options
   */
  public function form($instance) {
    if (isset($instance['title'])) {
      $title = $instance['title'];
    } else {
      $title = __('Recent Press Releases', 'RecentPressReleases_domain');
    }

    // Widget admin form
    ?>
      <p>
        <label for="<?= $this->get_field_id('title') ?>">
          <?php _e('Title:') ?>
        </label>
        <input class="widefat" id="<?= $this->get_field_id('title') ?>" name="<?= $this->get_field_name('title') ?>" type="text" value="<?= esc_attr($title) ?>" />
      </p>
    <?php
	}

  /**
   * Process widget options when saved
   *
   * @param array $new_instance The new options
	 * @param array $old_instance The previous options
   */
  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']):
   '';
    return $instance;
  }
}

add_action('widgets_init', function () {
  $widgetNames = [
    'SortWidget',
    'RecentPressReleases'
  ];
  foreach ($widgetNames as $widgetName) {
    register_widget($widgetName);
  }
});
