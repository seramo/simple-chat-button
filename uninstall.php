<?php
// Die if uninstall file is not called by WordPress
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// Delete options
$scb_options = array(
	'scb_whatsapp_number',
	'scb_whatsapp_chat_text',
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
foreach ($scb_options as $option) {
    if (get_option($option)) {
        delete_option($option);
    }
}