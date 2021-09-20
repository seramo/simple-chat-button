<?php
/**
 * Plugin Name: Simple Chat Button
 * Description: Adds a beautiful WhatsApp Sticky Button on the WordPress frontend.
 * Author:      Rasoul Mousavian
 * Author URI:  https://seramo.ir
 * Version:     1.2.0
 * License:     GPLv2
 * Text Domain: scb
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('SCB_VERSION', '1.2.0');
define('SCB_NAME', plugin_basename(__FILE__));
define('SCB_DIR', plugin_dir_path(__FILE__));
define('SCB_URI', plugin_dir_url(__FILE__));
define('SCB_INC', trailingslashit(SCB_DIR . 'includes'));

// Check main class exists
if (!class_exists('SCB_Main')) {

    // Include whatsapp chat button frontend
    include SCB_INC . 'frontend.php';

    // Define main class
    class SCB_Main {

        public function __construct() {
            // Add settings page
            add_action('admin_menu', array($this, 'scb_settings_page'));

            // Register settings
            add_action('admin_init', array($this, 'scb_register_settings'));

            // Add settings link
            add_filter('plugin_action_links_' . SCB_NAME, array($this, 'scb_add_settings_link'));

            // Loads translated strings
            load_plugin_textdomain('scb', false, dirname(SCB_NAME) . '/languages');
        }

        // Add setting page to options submenu
        function scb_settings_page() {
            add_submenu_page(
                'options-general.php',
                esc_html__('Simple Chat Button', 'scb'),
                esc_html__('Simple Chat Button', 'scb'),
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
                'scb_button_position',
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
            add_option('scb_whatsapp_chat_text', esc_html__('Hello', 'scb'));
            add_option('scb_button_status', '1');
            add_option('scb_button_text', esc_html__('Need Help?', 'scb'));
            add_option('scb_button_position', 'right');
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

        // Add settings link
        function scb_add_settings_link($links) {
            $links[] = sprintf('<a href="%1$s">%2$s</a>', admin_url('options-general.php?page=simple-chat-button'), esc_html__('Settings', 'scb'));
            $links[] = sprintf('<a href="https://seramo.ir">%1$s</a>', esc_html__('Website', 'scb'));
            return $links;
        }

    }

    new SCB_Main();
}