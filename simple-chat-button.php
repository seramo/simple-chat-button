<?php
/*
 * Plugin Name: Simple Chat Button
 * Description: Adds a beautiful WhatsApp Sticky Button on the WordPress frontend.
 * Author:      Rasoul Mousavian
 * Author URI:  https://seramo.ir
 * Version:     1.8.0
 * License:     GPLv2
 * Text Domain: simple-chat-button
 * Domain Path: /languages/
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('SCB_VERSION', '1.8.0');
define('SCB_NAME', plugin_basename(__FILE__));
define('SCB_DIR', plugin_dir_path(__FILE__));
define('SCB_URI', plugin_dir_url(__FILE__));
define('SCB_INC', trailingslashit(SCB_DIR . 'includes'));

// Check main class exists
if (!class_exists('SCB_Main')) {

    // Include whatsapp chat button frontend
    include SCB_INC . 'custom_functions.php';
    include SCB_INC . 'frontend.php';

    // Define main class
    class SCB_Main {

        public function __construct() {
            // Add settings page
            add_action('admin_menu', array($this, 'scb_settings_page'));

            // Register settings
            add_action('admin_init', array($this, 'scb_register_settings'));

            // Add custom meta box
            add_action('add_meta_boxes', array($this,'scb_add_custom_meta_box'));

            // Add save custom meta box data
            add_action('save_post', array($this, 'scb_save_post_data'));

            // Add settings link
            add_filter('plugin_action_links_' . SCB_NAME, array($this, 'scb_add_settings_link'));

            // Loads translated strings
            load_plugin_textdomain('simple-chat-button', false, dirname(SCB_NAME) . '/languages');
        }

        // Add setting page to options submenu
        function scb_settings_page() {
            add_submenu_page(
                'options-general.php',
                esc_html__('Simple Chat Button', 'simple-chat-button'),
                esc_html__('Simple Chat Button', 'simple-chat-button'),
                'manage_options',
                'simple-chat-button',
                array($this, 'scb_settings_page_callback')
            );
        }

        // Register settings
        function scb_register_settings() {
			$scb_settings_args = array (
				'sanitize_callback' => 'sanitize_text_field'
			);
            $scb_whatsapp_options = array(
                'scb_whatsapp_number',
                'scb_whatsapp_chat_text'
            );
            $scb_button_options = array(
                'scb_button_status',
                'scb_button_text',
                'scb_button_target',
                'scb_button_position',
                'scb_button_z_index',
                'scb_desktop_link_type',
                'scb_desktop_bottom_margin',
                'scb_tablet_bottom_margin',
                'scb_mobile_bottom_margin'
            );
            foreach ($scb_whatsapp_options as $option) {
                register_setting('scb-whatsapp-settings', $option, $scb_settings_args);
            }
            foreach ($scb_button_options as $option) {
                register_setting('scb-button-settings', $option, $scb_settings_args);
            }
            // Initialize options
            add_option('scb_whatsapp_chat_text', esc_html__('Hello', 'simple-chat-button'));
            add_option('scb_button_status', '1');
            add_option('scb_button_text', esc_html__('Need Help?', 'simple-chat-button'));
            add_option('scb_button_target', '_blank');
            add_option('scb_button_position', 'right');
            add_option('scb_desktop_link_type', 'api');
            add_option('scb_desktop_bottom_margin', '20');
            add_option('scb_tablet_bottom_margin', '20');
            add_option('scb_mobile_bottom_margin', '20');
        }

        // Settings page callback
        function scb_settings_page_callback() {
            // Check access
            if (!current_user_can("manage_options") && !is_admin()) {
                return;
            }
            // Include settings page
            include SCB_INC . 'settings-page.php';
        }

        // Add custom meta box
        function scb_add_custom_meta_box() {
            $screens = array(
                'post',
                'page',
            );
            foreach ($screens as $screen) {
                add_meta_box(
                    'scb_custom_meta_box',
                    esc_html__('Simple Chat Button Settings', 'simple-chat-button'),
                    array($this, 'scb_custom_meta_box_callback'),
                    $screen,
                    'normal',
                    'default',
                );
            }
        }

        // Custom meta box html
        function scb_custom_meta_box_callback($post) {
            // Check access
            if (!current_user_can("manage_options") && !is_admin()) {
                return;
            }
            // Include meta box html
            include SCB_INC . 'meta-box.php';
        }

        // Save custom meta box data
        function scb_save_post_data($post_id){
            // Check plugin nonce is set
            if (!isset($_POST['scb_settings_meta_box_nonce'])) {
                return $post_id;
            }

            // Verify that the nonce is valid
            $nonce = sanitize_text_field($_POST['scb_settings_meta_box_nonce']);
            if (!wp_verify_nonce($nonce, 'scb_settings_meta_box')) {
                return $post_id;
            }

            // Check auto save form
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }

            // Check the user permissions
            if ('page' == $_POST['post_type']) {
                if (!current_user_can('edit_page', $post_id)) {
                    return $post_id;
                }
            } else {
                if (!current_user_can('edit_post', $post_id)) {
                    return $post_id;
                }
            }

            // Sanitize the user input and save post meta
            $button_hide_status = sanitize_text_field($_POST['scb_button_hide_status']);
            if (!empty($button_hide_status)) {
                update_post_meta($post_id, '_scb_button_hide_status', $button_hide_status);
            } else {
                delete_post_meta($post_id, '_scb_button_hide_status');
            }
        }

        // Add settings link
        function scb_add_settings_link($links) {
            $links[] = sprintf('<a href="%1$s">%2$s</a>', admin_url('options-general.php?page=simple-chat-button'), esc_html__('Settings', 'simple-chat-button'));
            $links[] = sprintf('<a href="https://seramo.ir">%1$s</a>', esc_html__('Website', 'simple-chat-button'));
            return $links;
        }

    }

    new SCB_Main();
}