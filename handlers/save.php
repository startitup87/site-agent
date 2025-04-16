<?php
add_action('wp_ajax_site_agent_save', function() {
    check_ajax_referer('site_agent_nonce', 'nonce');
    $data = $_POST;
    // Handle file upload if present
    if (!empty($_FILES['logo']['name'])) {
        $upload = wp_handle_upload($_FILES['logo'], ['test_form' => false]);
        if (!isset($upload['error'])) {
            $data['logo_url'] = $upload['url'];
        }
    }
    unset($data['action'], $data['nonce']);
    $json_path = dirname(__DIR__) . '/presets/context.json';
    if (!file_exists(dirname($json_path))) {
        mkdir(dirname($json_path), 0755, true);
    }
    file_put_contents($json_path, json_encode($data, JSON_PRETTY_PRINT));
    wp_send_json_success('Form data saved!');
});
