<?php

class SA_Settings {

    public function __construct() {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('rest_api_init', [$this, 'register_ai_endpoint']);
    }

    public function add_settings_page() {
        add_options_page(
            'Site Agent Settings',
            'Site Agent',
            'manage_options',
            'site-agent-settings',
            [$this, 'render_settings_page']
        );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Site Agent Settings</h1>
            <form method="post" action="options.php">
                <?php
                    settings_fields('sa_settings_group');
                    do_settings_sections('sa_settings');
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register_ai_endpoint() {
        register_rest_route('site-agent/v1', '/context/ai', [
            'methods' => 'POST',
            'callback' => [$this, 'handle_ai_request'],
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ]);
    }

    public function handle_ai_request($request) {
        $prompt = $request->get_param('prompt');
        $api_key = get_option('sa_openai_key', '');

        if (!$api_key) {
            return new WP_Error('no_key', 'OpenAI API key is missing.', ['status' => 400]);
        }

        $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type'  => 'application/json',
            ],
            'body' => json_encode([
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a WordPress site builder assistant.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
            ]),
        ]);

        if (is_wp_error($response)) {
            return new WP_Error('ai_error', 'Error reaching OpenAI.', ['status' => 500]);
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        $result = $body['choices'][0]['message']['content'] ?? '';

        if (!$result) {
            return new WP_Error('empty_result', 'No content returned by AI.', ['status' => 500]);
        }

        file_put_contents(__DIR__ . '/context.json', $result);
        return ['message' => 'Context generated and saved.', 'context' => json_decode($result, true)];
    }
}
