<?php

require_once plugin_dir_path(__FILE__) . 'class-wp-site-agent-site-builder.php';

class WP_Site_Agent_Core {

    private $site_builder;

    public function __construct() {
        $this->site_builder = new WP_Site_Agent_Site_Builder();
    }

    public function initialize() {
        // Hook into WordPress actions and filters here.
        add_action('admin_menu', [$this, 'add_admin_menu']);
    }

    public function add_admin_menu() {
        // Add a menu item in the WordPress admin dashboard.
        add_menu_page(
            'WP Site Agent',
            'Site Agent',
            'manage_options',
            'wp-site-agent',
            [$this, 'render_admin_page'],
            'dashicons-admin-generic'
        );
    }

    public function render_admin_page() {
        echo '<div class="wrap">';
        echo '<h1>WP Site Agent</h1>';
        echo '<p>Welcome to the WP Site Agent plugin. Use this tool to build, test, and deploy WordPress sites.</p>';

        // OpenAI API Key Section
        echo '<h2>OpenAI Integration</h2>';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wp_site_agent_openai_action'])) {
            check_admin_referer('wp_site_agent_openai_settings');
            $action = sanitize_text_field($_POST['wp_site_agent_openai_action']);
            if ($action === 'save_key') {
                $api_key = sanitize_text_field($_POST['openai_api_key']);
                $this->site_builder->save_openai_api_key($api_key);
                echo '<div class="notice notice-success is-dismissible"><p>API key saved.</p></div>';
            } elseif ($action === 'test_key') {
                $api_key = sanitize_text_field($_POST['openai_api_key']);
                $result = esc_html($this->site_builder->test_openai_api_key($api_key));
                echo '<div class="notice notice-info is-dismissible"><p>Test result: ' . $result . '</p></div>';
            }
        }
        $saved_key = esc_attr($this->site_builder->get_openai_api_key());
        echo '<form method="post">';
        wp_nonce_field('wp_site_agent_openai_settings');
        echo '<label for="openai_api_key"><strong>OpenAI API Key:</strong></label><br />';
        echo '<input type="text" id="openai_api_key" name="openai_api_key" value="' . $saved_key . '" size="50" style="max-width:100%" autocomplete="off" />';
        echo '<br /><br />';
        echo '<button class="button button-primary" name="wp_site_agent_openai_action" value="save_key">Save API Key</button> ';
        echo '<button class="button" name="wp_site_agent_openai_action" value="test_key">Test API Key</button>';
        echo '</form>';
        echo '<hr />';

        // Example site actions
        echo '<h2>Site Actions</h2>';
        echo '<form method="post">';
        echo '<button class="button" name="action" value="create_site">Create Site</button> ';
        echo '<button class="button" name="action" value="test_site">Test Site</button> ';
        echo '<button class="button" name="action" value="deploy_site">Deploy Site</button> ';
        echo '</form>';

        // Handle site actions
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = sanitize_text_field($_POST['action']);
            switch ($action) {
                case 'create_site':
                    echo '<div class="notice notice-info is-dismissible"><p>' . esc_html($this->site_builder->create_site('Example Site', 'https://example.com')) . '</p></div>';
                    break;
                case 'test_site':
                    echo '<div class="notice notice-info is-dismissible"><p>' . esc_html($this->site_builder->test_site('https://example.com')) . '</p></div>';
                    break;
                case 'deploy_site':
                    echo '<div class="notice notice-info is-dismissible"><p>' . esc_html($this->site_builder->deploy_site('https://example.com')) . '</p></div>';
                    break;
            }
        }
        echo '</div>';
    }
}
