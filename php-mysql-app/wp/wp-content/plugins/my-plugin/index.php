<?php
/*
Plugin Name: wx Test plugin
Description: A simple test plugin to demo shortcodes and other wp features
Version: 1.0
Author: sunny
*/

// Make sure we don't expose any info if called directly
if (!defined('ABSPATH')) {
    exit;
}

// import test-box shortcodes
require_once __DIR__ . '/shortcodes/test-box.php';

// Create plugin directory and CSS file on activation
register_activation_hook(__FILE__, 'test_shortcode_activation');

function test_shortcode_activation() {
    // Create css directory if it doesn't exist
    $css_dir = plugin_dir_path(__FILE__) . 'css';
    if (!file_exists($css_dir)) {
        mkdir($css_dir, 0755);
    }

    // Create CSS file if it doesn't exist
    $css_file = $css_dir . '/style.css';
    if (!file_exists($css_file)) {
        $css_content = "
        .test-box {
            margin: 20px 0;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .test-box-title {
            margin: 0 0 10px 0;
            padding: 0;
            font-size: 1.2em;
        }
        
        .test-box-content {
            font-size: 1em;
            line-height: 1.4;
        }
        
        /* Colors */
        .test-box-blue {
            background-color: #e8f4fd;
            border: 1px solid #3498db;
        }
        
        .test-box-green {
            background-color: #e8fdf0;
            border: 1px solid #2ecc71;
        }
        
        .test-box-red {
            background-color: #fde8e8;
            border: 1px solid #e74c3c;
        }
        
        /* Sizes */
        .test-box-small {
            max-width: 300px;
        }
        
        .test-box-normal {
            max-width: 500px;
        }
        
        .test-box-large {
            max-width: 700px;
        }";
        
        file_put_contents($css_file, $css_content);
    }
}

// Add Settings link in plugins page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'test_shortcode_settings_link');

function test_shortcode_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=test-shortcode-settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}

