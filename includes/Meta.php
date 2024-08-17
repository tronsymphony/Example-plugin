<?php

namespace Literati\Example;

/**
 * Meta class to handle custom meta fields for the Promotion post type.
 */
class Meta {
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_meta_api'));
        add_action('add_meta_boxes', array($this, 'add_promotion_meta_boxes'));
        add_action('save_post', array($this, 'save_promotion_meta_box_data'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_media_uploader'));
        add_action('init', array($this, 'flush_rewrite_rules_on_activation'));
    }

    public function flush_rewrite_rules_on_activation() {
        flush_rewrite_rules();
    }

    public function register_meta_api() {


        register_meta('post', '_promotion_header', array(
            'object_subtype' => 'promotion',
            'type'         => 'string',
            'description'  => 'Promotion Header',
            'single'       => true,
            'show_in_rest' => true,
        ));
        
        register_meta('post', '_promotion_text', array(
            'type'         => 'string',
            'description'  => 'Promotion Text',
            'single'       => true,
            'show_in_rest' => true,
        ));
        
        register_meta('post', '_promotion_button', array(
            'type'         => 'string',
            'description'  => 'Promotion Button Text',
            'single'       => true,
            'show_in_rest' => true,
        ));
        
        register_meta('post', '_promotion_image', array(
            'type'         => 'string',
            'description'  => 'Promotion Image URL',
            'single'       => true,
            'show_in_rest' => true,
        ));
    }
    

    public function add_promotion_meta_boxes() {
        add_meta_box(
            'promotion_meta_box',
            __('Promotion Details', 'literati-example'),
            array($this, 'render_promotion_meta_box'),
            'promotion',
            'normal',
            'high'
        );
    }

    public function render_promotion_meta_box($post) {
        $header = get_post_meta($post->ID, '_promotion_header', true);
        $text = get_post_meta($post->ID, '_promotion_text', true);
        $button = get_post_meta($post->ID, '_promotion_button', true);
        $image = get_post_meta($post->ID, '_promotion_image', true);

        wp_nonce_field('save_promotion_meta_box_data', 'promotion_meta_box_nonce');

        echo '<p>';
        echo '<label for="promotion_header">' . __('Header', 'literati-example') . '</label><br />';
        echo '<input type="text" name="promotion_header" id="promotion_header" value="' . esc_attr($header) . '" size="30" />';
        echo '</p>';
        echo '<p>';
        echo '<label for="promotion_text">' . __('Text', 'literati-example') . '</label><br />';
        echo '<textarea name="promotion_text" id="promotion_text" rows="5" cols="30">' . esc_textarea($text) . '</textarea>';
        echo '</p>';
        echo '<p>';
        echo '<label for="promotion_button">' . __('Button Text', 'literati-example') . '</label><br />';
        echo '<input type="text" name="promotion_button" id="promotion_button" value="' . esc_attr($button) . '" size="30" />';
        echo '</p>';
        echo '<p>';
        echo '<label for="promotion_image">' . __('Image URL', 'literati-example') . '</label><br />';
        echo '<input type="text" name="promotion_image" id="promotion_image" value="' . esc_attr($image) . '" size="30" />';
        echo '<button type="button" class="upload_image_button button">' . __('Upload Image', 'literati-example') . '</button>';
        echo '</p>';
?>
<script>
jQuery(document).ready(function($) {
    var file_frame;
    $('.upload_image_button').on('click', function(event) {
        event.preventDefault();

        if (file_frame) {
            file_frame.open();
            return;
        }

        file_frame = wp.media.frames.file_frame = wp.media({
            title: '<?php _e('Select or Upload an Image', 'literati-example'); ?>',
            button: {
                text: '<?php _e('Use this image', 'literati-example'); ?>',
            },
            multiple: false  
        });

        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            $('#promotion_image').val(attachment.url);
        });

        file_frame.open();
    });
});
</script>
<?php
        
    }

    public function enqueue_media_uploader() {
        global $typenow;
        if ($typenow === 'promotion') {
            wp_enqueue_media();
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
        }
    }

    public function save_promotion_meta_box_data($post_id) {
        if (!isset($_POST['promotion_meta_box_nonce']) || !wp_verify_nonce($_POST['promotion_meta_box_nonce'], 'save_promotion_meta_box_data')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['promotion_header'])) {
            update_post_meta($post_id, '_promotion_header', sanitize_text_field($_POST['promotion_header']));
        }
        if (isset($_POST['promotion_text'])) {
            update_post_meta($post_id, '_promotion_text', sanitize_textarea_field($_POST['promotion_text']));
        }
        if (isset($_POST['promotion_button'])) {
            update_post_meta($post_id, '_promotion_button', sanitize_text_field($_POST['promotion_button']));
        }
        if (isset($_POST['promotion_image'])) {
            update_post_meta($post_id, '_promotion_image', esc_url_raw($_POST['promotion_image']));
        }
    }
}
