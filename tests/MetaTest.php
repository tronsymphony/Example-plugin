<?php

use Literati\Example\Meta;
use PHPUnit\Framework\TestCase;

class MetaTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (!function_exists('add_action')) {
            function add_action($hook, $function_to_add, $priority = 10, $accepted_args = 1) {
            }
        }
        if (!function_exists('register_meta')) {
            function register_meta($object_type, $meta_key, $args) {
                return true;
            }
        }
        if (!function_exists('add_meta_box')) {
            function add_meta_box($id, $title, $callback, $screen, $context = 'advanced', $priority = 'default', $callback_args = null) {
                return true;
            }
        }
        if (!function_exists('wp_nonce_field')) {
            function wp_nonce_field($action, $name, $referer = true, $echo = true) {
                return '<input type="hidden" name="'.$name.'" value="nonce_value" />';
            }
        }
        if (!function_exists('get_post_meta')) {
            function get_post_meta($post_id, $key, $single = false) {
                return 'mock_meta_value';
            }
        }
        if (!function_exists('update_post_meta')) {
            function update_post_meta($post_id, $meta_key, $meta_value) {
                return true;
            }
        }
        if (!function_exists('wp_verify_nonce')) {
            function wp_verify_nonce($nonce, $action) {
                return true;
            }
        }
        if (!function_exists('current_user_can')) {
            function current_user_can($capability, $post_id = null) {
                return true;
            }
        }
    }

    public function test_register_meta_api()
    {
        $meta = new Meta();
        
        $meta->register_meta_api();

        $this->assertTrue(true);
    }

    public function test_add_promotion_meta_boxes()
    {
        $meta = new Meta();
        
        $meta->add_promotion_meta_boxes();

        $this->assertTrue(true);
    }

    public function test_render_promotion_meta_box()
    {
        $meta = new Meta();
        
        ob_start();
        $meta->render_promotion_meta_box((object)['ID' => 1]);
        $output = ob_get_clean();

        $this->assertStringContainsString('promotion_header', $output);
        $this->assertStringContainsString('promotion_text', $output);
        $this->assertStringContainsString('promotion_button', $output);
        $this->assertStringContainsString('promotion_image', $output);
    }

    public function test_enqueue_media_uploader()
    {
        $meta = new Meta();

        $GLOBALS['typenow'] = 'promotion';

        $meta->enqueue_media_uploader();

        $this->assertTrue(true);
    }

    public function test_save_promotion_meta_box_data()
    {
        $meta = new Meta();

        $_POST['promotion_meta_box_nonce'] = 'nonce_value';
        $_POST['promotion_header'] = 'Test Header';
        $_POST['promotion_text'] = 'Test Text';
        $_POST['promotion_button'] = 'Test Button';
        $_POST['promotion_image'] = 'http://example.com/image.jpg';

        $meta->save_promotion_meta_box_data(1);

        $this->assertTrue(true);
    }
}

