<?php

class WP_Site_Agent_Site_Builder {

    public function create_site($site_name, $site_url) {
        // Logic to create a new WordPress site programmatically.
        // This is a placeholder for the actual implementation.
        return "Site '$site_name' created at $site_url.";
    }

    public function test_site($site_url) {
        // Logic to test the WordPress site.
        // This is a placeholder for the actual implementation.
        return "Testing site at $site_url completed successfully.";
    }

    public function deploy_site($site_url) {
        // Logic to deploy the WordPress site.
        // This is a placeholder for the actual implementation.
        return "Site at $site_url deployed successfully.";
    }

    public function edit_image($image_path, $operations) {
        // Logic to edit images based on the provided operations.
        // This is a placeholder for the actual implementation.
        return "Image at $image_path edited with operations: " . implode(', ', $operations);
    }

    public function get_site_template($niche) {
        // Returns template configuration based on the industry niche
        switch (strtolower($niche)) {
            case 'blog':
                return [
                    'name' => 'Blog Site',
                    'description' => 'A standard blog template with posts, categories, tags, and author profiles.',
                    'features' => [
                        'Customizable homepage',
                        'Post listing and single post templates',
                        'Category and tag archives',
                        'Author pages',
                        'Sidebar widgets (recent posts, categories, search)',
                        'Comment system',
                        'SEO basics',
                    ],
                    'recommended_plugins' => [
                        'Yoast SEO',
                        'Akismet Anti-Spam',
                        'WP Super Cache',
                    ],
                    'default_pages' => [
                        'Home', 'About', 'Contact', 'Blog'
                    ],
                ];
            case 'ecommerce':
                return [
                    'name' => 'E-Commerce Site',
                    'description' => 'A template for online stores with product catalog, cart, and checkout.',
                    'features' => [
                        'WooCommerce integration',
                        'Product grid and single product pages',
                        'Shopping cart and checkout',
                        'Customer account area',
                        'Order management',
                        'Payment gateway support',
                        'Product search and filters',
                        'Featured products and promotions',
                    ],
                    'recommended_plugins' => [
                        'WooCommerce',
                        'WooCommerce Payments',
                        'Mailchimp for WooCommerce',
                        'Jetpack',
                    ],
                    'default_pages' => [
                        'Shop', 'Cart', 'Checkout', 'My Account', 'Home', 'Contact'
                    ],
                ];
            case 'ai coach':
            case 'aicoach':
                return [
                    'name' => 'AI Coach Site',
                    'description' => 'A template for AI-powered coaching, scheduling, and content delivery.',
                    'features' => [
                        'Booking/scheduling system',
                        'AI chatbot integration',
                        'Resource library (videos, articles, downloads)',
                        'User registration and profiles',
                        'Progress tracking/dashboard',
                        'Contact and support forms',
                        'Testimonials and case studies',
                    ],
                    'recommended_plugins' => [
                        'WP Simple Booking Calendar',
                        'WPForms',
                        'MemberPress',
                        'Chatbot plugins (e.g., WP-Chatbot for OpenAI)',
                    ],
                    'default_pages' => [
                        'Home', 'Book a Session', 'Resources', 'Dashboard', 'Contact'
                    ],
                ];
            default:
                return [
                    'name' => 'Default',
                    'description' => 'A basic WordPress site template.',
                    'features' => [
                        'Customizable homepage',
                        'Basic blog functionality',
                    ],
                    'recommended_plugins' => [],
                    'default_pages' => ['Home', 'Blog', 'Contact'],
                ];
        }
    }
public function install_and_activate_plugins_from_context($context_path = __DIR__ . '/context.json') {
        if (!file_exists($context_path)) {
            return 'Context file not found.';
        }
        $context = json_decode(file_get_contents($context_path), true);
        $niche = isset($context['niche']) ? $context['niche'] : '';
        $site_type = isset($context['site_type']) ? $context['site_type'] : '';
        $template = $this->get_site_template($niche ?: $site_type);
        if (empty($template['recommended_plugins'])) {
            return 'No recommended plugins for this context.';
        }
        $results = [];
        include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        include_once ABSPATH . 'wp-admin/includes/plugin.php';
        foreach ($template['recommended_plugins'] as $plugin_name) {
            $api = plugins_api('plugin_information', ['slug' => sanitize_title($plugin_name), 'fields' => ['sections' => false]]);
            if (is_wp_error($api) || empty($api->slug)) {
                $results[] = "Could not find plugin: $plugin_name";
                continue;
            }
            $upgrader = new Plugin_Upgrader();
            $install_result = $upgrader->install($api->download_link);
            if (is_wp_error($install_result)) {
                $results[] = "Failed to install $plugin_name: " . $install_result->get_error_message();
                continue;
            }
            $plugin_file = $api->slug . '/' . $api->slug . '.php';
            if (!is_plugin_active($plugin_file)) {
                activate_plugin($plugin_file);
                $results[] = "Installed and activated: $plugin_name";
            } else {
                $results[] = "$plugin_name already active.";
            }
        }
        return implode("\n", $results);
    }
// Save OpenAI API key to WordPress options
    public function save_openai_api_key($api_key) {
        return update_option('wp_site_agent_openai_api_key', $api_key);
    }

    // Retrieve OpenAI API key from WordPress options
    public function get_openai_api_key() {
        return get_option('wp_site_agent_openai_api_key', '');
    }

    // Test OpenAI API key by making a simple request
    public function test_openai_api_key($api_key = null) {
        if (!$api_key) {
            $api_key = $this->get_openai_api_key();
        }
        if (empty($api_key)) {
            return 'No OpenAI API key set.';
        }
        $url = 'https://api.openai.com/v1/models';
        $args = [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type'  => 'application/json',
            ],
            'timeout' => 15,
        ];
        $response = wp_remote_get($url, $args);
        if (is_wp_error($response)) {
            return 'Request error: ' . $response->get_error_message();
        }
        $code = wp_remote_retrieve_response_code($response);
        if ($code === 200) {
            return 'OpenAI API key is valid.';
        } else {
            $body = wp_remote_retrieve_body($response);
            return 'OpenAI API test failed. HTTP ' . $code . ': ' . $body;
        }
    }
}
