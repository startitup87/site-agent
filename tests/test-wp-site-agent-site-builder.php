<?php
// tests/test-wp-site-agent-site-builder.php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../includes/class-wp-site-agent-site-builder.php';

class WP_Site_Agent_Site_Builder_Test extends TestCase {
    private $builder;

    protected function setUp(): void {
        $this->builder = new WP_Site_Agent_Site_Builder();
    }

    public function test_create_site() {
        $result = $this->builder->create_site('Test Site', 'https://test.com');
        $this->assertStringContainsString("Site 'Test Site' created at https://test.com.", $result);
    }

    public function test_test_site() {
        $result = $this->builder->test_site('https://test.com');
        $this->assertStringContainsString('Testing site at https://test.com completed successfully.', $result);
    }

    public function test_deploy_site() {
        $result = $this->builder->deploy_site('https://test.com');
        $this->assertStringContainsString('Site at https://test.com deployed successfully.', $result);
    }

    public function test_edit_image() {
        $result = $this->builder->edit_image('/path/to/image.jpg', ['resize', 'crop']);
        $this->assertStringContainsString('Image at /path/to/image.jpg edited with operations: resize, crop', $result);
    }

    public function test_get_site_template_blog() {
        $template = $this->builder->get_site_template('blog');
        $this->assertEquals('Blog Site', $template['name']);
        $this->assertContains('Customizable homepage', $template['features']);
    }

    public function test_get_site_template_ecommerce() {
        $template = $this->builder->get_site_template('ecommerce');
        $this->assertEquals('E-Commerce Site', $template['name']);
        $this->assertContains('WooCommerce integration', $template['features']);
    }

    public function test_get_site_template_aicoach() {
        $template = $this->builder->get_site_template('ai coach');
        $this->assertEquals('AI Coach Site', $template['name']);
        $this->assertContains('AI chatbot integration', $template['features']);
    }

    public function test_get_site_template_default() {
        $template = $this->builder->get_site_template('unknown');
        $this->assertEquals('Default', $template['name']);
        $this->assertContains('Customizable homepage', $template['features']);
    }

    public function test_install_and_activate_plugins_from_context() {
        // Create a mock context file with a known niche
        $mock_context = [
            'niche' => 'blog',
            'site_type' => '',
        ];
        $mock_path = __DIR__ . '/../includes/mock-context.json';
        file_put_contents($mock_path, json_encode($mock_context));
        // Since actual plugin install/activation can't run in PHPUnit, just check the logic up to plugin list
        $result = $this->builder->install_and_activate_plugins_from_context($mock_path);
        $this->assertIsString($result);
        // Clean up
        unlink($mock_path);
    }
}
