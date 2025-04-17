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
        // Render the admin page for the plugin.
        echo '<h1>WP Site Agent</h1>';
        echo '<p>Welcome to the WP Site Agent plugin. Use this tool to build, test, and deploy WordPress sites.</p>';

        // Example buttons to trigger actions.
        echo '<form method="post">';
        echo '<button name="action" value="create_site">Create Site</button> ';
        echo '<button name="action" value="test_site">Test Site</button> ';
        echo '<button name="action" value="deploy_site">Deploy Site</button> ';
        echo '</form>';

        // Handle form submissions.
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            $action = $_POST['action'];
            switch ($action) {
                case 'create_site':
                    echo '<p>' . $this->site_builder->create_site('Example Site', 'https://example.com') . '</p>';
                    break;
                case 'test_site':
                    echo '<p>' . $this->site_builder->test_site('https://example.com') . '</p>';
                    break;
                case 'deploy_site':
                    echo '<p>' . $this->site_builder->deploy_site('https://example.com') . '</p>';
                    break;
            }
        }
    }
}
