<?php
/**
 * Plugin Name: WP Site Agent
 * Description: A streamlined agent for building, testing, and deploying WordPress sites with image generation and editing capabilities.
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL-2.0+
 */

// Prevent direct access to the file.
if (!defined('ABSPATH')) {
    exit;
}

// Include core functionality.
require_once plugin_dir_path(__FILE__) . 'includes/class-wp-site-agent-core.php';

// Initialize the plugin.
function wp_site_agent_init() {
    $core = new WP_Site_Agent_Core();
    $core->initialize();
}
add_action('plugins_loaded', 'wp_site_agent_init');
