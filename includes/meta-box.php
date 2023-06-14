<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Custom meta box html
wp_nonce_field('scb_settings_meta_box', 'scb_settings_meta_box_nonce');
$post_id = get_the_ID();
$button_hide_status = get_post_meta($post_id, '_scb_button_hide_status', true);
?>
<p class="meta-options">
    <label for="scb_button_hide_status" class="selectit">
        <input name="scb_button_hide_status" type="checkbox" id="scb_button_hide_status" value="1" <?php checked('1', esc_attr($button_hide_status)); ?>>
        <?php echo esc_html__('Disable chat button on this page', 'simple-chat-button'); ?>
    </label>
</p>