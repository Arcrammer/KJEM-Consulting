<?php
	// Creating the widget
  class SortWidget extends WP_Widget {
    function __construct() {
      parent::__construct(
      // Widget name will appear in UI
     'Sort',
      // Widget description
      __('Sort Featured Videos', 'SortWidget_domain'),
      [
       'description'=> __('Sort featured videos by custom fields (or should I say \'supports\')',
       'SortWidget_domain')
      ]);
    }

    /**
     * Front-end stuff
     */
    public function widget($args, $instance) {
      $title = apply_filters('widget_title', $instance['title']);
      // before and after widget arguments are defined by themes
      echo $args['before_widget'];

      if (!empty($title)) echo $args['before_title'].$title.$args['after_title'];
      // This is where you run the code and display the output
      echo __('This is where the sorting stuff goes. ☺️', 'SortWidget_domain');
      echo $args['after_widget'];
    }

    /**
     * Options for the form in the admin area
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
     */
    public function update($new_instance, $old_instance) {
      $instance = array();
      $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']):
     '';
      return $instance;
    }
  }

  // Class SortWidget ends here
	// Register and load the widget
	function wpb_load_widget() {
    register_widget('SortWidget');
  }

  add_action('widgets_init', 'wpb_load_widget');
