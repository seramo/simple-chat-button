<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Get the active tab from the $_GET parameter
$default_tab = 'whatsapp-settings';
$tab = isset($_GET['tab'])?sanitize_text_field($_GET['tab']):$default_tab;
$settings_url = "options-general.php?page=simple-chat-button";
$whatsapp_settings_url = admin_url($settings_url.'&tab=whatsapp-settings');
$button_settings_url = admin_url($settings_url.'&tab=button-settings');

// Initialize variables
$whatsapp_number = get_option('scb_whatsapp_number');
$whatsapp_chat_text = get_option('scb_whatsapp_chat_text');
$button_status = intval(get_option('scb_button_status'));
$button_text = get_option('scb_button_text');
$button_position = get_option('scb_button_position');
$desktop_bottom_margin = intval(get_option('scb_desktop_bottom_margin'));
$tablet_bottom_margin = intval(get_option('scb_tablet_bottom_margin'));
$mobile_bottom_margin = intval(get_option('scb_mobile_bottom_margin'));
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <nav class="nav-tab-wrapper">
        <a href="<?php echo esc_url($whatsapp_settings_url); ?>" class="nav-tab <?php echo ($tab==='whatsapp-settings')?'nav-tab-active':''; ?>"><?php echo esc_html__('Whatsapp Settings', 'scb'); ?></a>
        <a href="<?php echo esc_url($button_settings_url); ?>" class="nav-tab <?php echo ($tab==='button-settings')?'nav-tab-active':''; ?>"><?php echo esc_html__('Button Settings', 'scb'); ?></a>
    </nav>
    <div class="tab-content">
        <form method="post" action="options.php">
            <?php ($tab==='whatsapp-settings')?settings_fields('scb-whatsapp-settings'):settings_fields('scb-button-settings'); ?>
            <table class="form-table">
                <?php if ($tab==='whatsapp-settings' || $tab!=='button-settings') { ?>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Whatsapp number', 'scb'); ?> :</th>
                        <td>
                            <input type="text" name="scb_whatsapp_number" id="scb_whatsapp_number" placeholder="<?php echo esc_html__('15551234567', 'scb'); ?>" dir="ltr" value="<?php echo esc_attr($whatsapp_number); ?>"/>
                            <p class="description"><?php echo esc_html__('Enter Whatsapp number with country code (without any plus, preceding zero, hyphen, brackets, space).', 'scb'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Whatsapp chat text', 'scb'); ?> <small style="font-weight: 400;"><?php echo esc_html__('(optional)','scb'); ?></small> :</th>
                        <td>
                            <input type="text" name="scb_whatsapp_chat_text" id="scb_whatsapp_chat_text" placeholder="<?php echo esc_html__('Hello', 'scb'); ?>" value="<?php echo esc_attr($whatsapp_chat_text);?>"/>
                        </td>
                    </tr>
                <?php } elseif ($tab==='button-settings') { ?>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Button status', 'scb'); ?> :</th>
                        <td>
                            <input type="checkbox" name="scb_button_status" id="scb_button_status" value="1" <?php checked('1', esc_attr($button_status));?>>
                            <span><?php echo esc_html__('Enabled', 'scb'); ?></span>
                        <td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Button text', 'scb'); ?> <small style="font-weight: 400"><?php echo esc_html__('(optional)','scb'); ?></small> :</th>
                        <td>
                            <input type="text" name="scb_button_text" id="scb_button_text" placeholder="<?php echo esc_html__('Need Help?', 'scb'); ?>" value="<?php echo esc_attr($button_text);?>"/>
                            <p class="description"><?php echo esc_html__('Leave this field empty to only show an icon.', 'scb'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Position', 'scb'); ?> :</th>
                        <td>
                            <select name="scb_button_position" id="scb_button_position" >
                                <option <?php selected(esc_attr($button_position), 'right'); ?> value="right"><?php echo esc_html__('Bottom Right', 'scb'); ?></option>
                                <option <?php selected(esc_attr($button_position), 'left'); ?> value="left"><?php echo esc_html__('Bottom Left', 'scb'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Bottom margin', 'scb'); ?> :</th>
                        <td>
                           <input type="number" name="scb_desktop_bottom_margin" id="scb_desktop_bottom_margin" min="0" max="100" step="5" value="<?php echo esc_attr($desktop_bottom_margin) ?>"/><span> <?php echo esc_html__('px (in Desktop)', 'scb'); ?> </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"</th>
                        <td>
                            <input type="number" name="scb_tablet_bottom_margin" id="scb_tablet_bottom_margin" min="0" max="100" step="5" value="<?php echo esc_attr($tablet_bottom_margin) ?>"/><span> <?php echo esc_html__('px (in Tablet)', 'scb'); ?> </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"></th>
                        <td>
                            <input type="number" name="scb_mobile_bottom_margin" id="scb_mobile_bottom_margin" min="0" max="100" step="5" value="<?php echo esc_attr($mobile_bottom_margin) ?>"/><span> <?php echo esc_html__('px (in Mobile)', 'scb'); ?> </span>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
</div>