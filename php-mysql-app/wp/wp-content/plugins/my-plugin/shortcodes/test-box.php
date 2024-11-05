<?php

// Register the shortcode when plugin is loaded
add_action('init', function () {
  add_shortcode('test_box', 'test_box_shortcode');
});

// Shortcode function
function test_box_shortcode($atts) {
    // Default attributes
    $attributes = shortcode_atts(array(
        'title' => 'Default Title',
        'color' => 'blue',
        'size' => 'normal'
    ), $atts);

    // Add custom CSS
    wp_enqueue_style('test-box-style', plugins_url('css/style.css', __DIR__));

    // wp_enqueue_script()

    // Build the output HTML
    $output = sprintf(
        '<div class="test-box test-box-%s test-box-%s">
            <h3 class="test-box-title">%s</h3>
            <div class="test-box-content">
                <p>Current Time: %s</p>
                <p>Your Site URL: %s</p>
                <p>WordPress Version: %s</p>
            </div>
        </div>',
        esc_attr($attributes['color']),
        esc_attr($attributes['size']),
        esc_html($attributes['title']),
        current_time('mysql'),
        get_site_url(),
        get_bloginfo('version')
    );

    return $output;
}

