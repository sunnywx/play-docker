
<?php
// Create a simple custom widget
class My_Custom_Widget extends WP_Widget {
    // Constructor
    public function __construct() {
        parent::__construct(
            'my_custom_widget', // Base ID
            'My Custom Widget', // Widget name in admin
            array('description' => 'A simple example widget')
        );
    }

    // Frontend display
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'Default Title';
        $text = !empty($instance['text']) ? $instance['text'] : 'Default Text';

        echo $args['before_widget'];
        echo $args['before_title'] . esc_html($title) . $args['after_title'];
        ?>
        <div class="my-widget-content">
            <p><?php echo esc_html($text); ?></p>
            <p>Posted on: <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
        <?php
        echo $args['after_widget'];
    }

    // Backend form
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $text = !empty($instance['text']) ? $instance['text'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" 
                   id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>">Content:</label>
            <textarea class="widefat" 
                      id="<?php echo $this->get_field_id('text'); ?>" 
                      name="<?php echo $this->get_field_name('text'); ?>"
                      rows="4"><?php echo esc_textarea($text); ?></textarea>
        </p>
        <?php
    }

    // Save widget settings
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) 
            ? strip_tags($new_instance['title']) 
            : '';
        $instance['text'] = (!empty($new_instance['text'])) 
            ? strip_tags($new_instance['text']) 
            : '';
        return $instance;
    }
}

// Register the widget
add_action('widgets_init', function () {
  register_widget('My_Custom_Widget');
});