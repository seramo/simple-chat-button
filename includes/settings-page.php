<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Get the active tab from the $_GET parameter
$default_tab = 'whatsapp-settings';
$tab = isset($_GET['tab'])?sanitize_text_field(wp_unslash($_GET['tab'])):$default_tab;
$settings_url = "options-general.php?page=simple-chat-button";
$whatsapp_settings_url = admin_url($settings_url.'&tab=whatsapp-settings');
$button_settings_url = admin_url($settings_url.'&tab=button-settings');
$whatsapp_automation_url = admin_url($settings_url.'&tab=whatsapp-automation');

// Initialize variables
$whatsapp_number = get_option('scb_whatsapp_number');
$whatsapp_chat_text = get_option('scb_whatsapp_chat_text');
$button_status = intval(get_option('scb_button_status'));
$button_text = get_option('scb_button_text');
$button_target = get_option('scb_button_target');
$button_position = get_option('scb_button_position');
$button_z_index = get_option('scb_button_z_index');
$desktop_link_type = get_option('scb_desktop_link_type');
$desktop_bottom_margin = intval(get_option('scb_desktop_bottom_margin'));
$tablet_bottom_margin = intval(get_option('scb_tablet_bottom_margin'));
$mobile_bottom_margin = intval(get_option('scb_mobile_bottom_margin'));

$wanotifier_url = 'https://link.seramo.ir/wan';
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <nav class="nav-tab-wrapper">
        <a href="<?php echo esc_url($whatsapp_settings_url); ?>" class="nav-tab <?php echo ($tab==='whatsapp-settings')?'nav-tab-active':''; ?>"><?php echo esc_html__('Whatsapp Settings', 'simple-chat-button'); ?></a>
        <a href="<?php echo esc_url($button_settings_url); ?>" class="nav-tab <?php echo ($tab==='button-settings')?'nav-tab-active':''; ?>"><?php echo esc_html__('Button Settings', 'simple-chat-button'); ?></a>
        <a href="<?php echo esc_url($whatsapp_automation_url); ?>" class="nav-tab <?php echo ($tab==='whatsapp-automation')?'nav-tab-active':''; ?>"><?php echo esc_html__('WhatsApp Automation', 'simple-chat-button'); ?></a>
    </nav>
    <div class="tab-content">
        <form method="post" action="options.php">
            <?php ($tab==='whatsapp-settings')?settings_fields('scb-whatsapp-settings'):settings_fields('scb-button-settings'); ?>
            <table class="form-table">
                <?php if ($tab==='whatsapp-settings') { ?>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Whatsapp number', 'simple-chat-button'); ?> :</th>
                        <td>
                            <input type="text" name="scb_whatsapp_number" id="scb_whatsapp_number" placeholder="<?php echo esc_html__('15551234567', 'simple-chat-button'); ?>" dir="ltr" value="<?php echo esc_attr($whatsapp_number); ?>"/>
                            <p class="description"><?php echo esc_html__('Enter Whatsapp number with country code (without any plus, preceding zero, hyphen, brackets, space).', 'simple-chat-button'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Whatsapp chat text', 'simple-chat-button'); ?> <small style="font-weight: 400;"><?php echo esc_html__('(optional)','simple-chat-button'); ?></small> :</th>
                        <td>
                            <input type="text" name="scb_whatsapp_chat_text" id="scb_whatsapp_chat_text" placeholder="<?php echo esc_html__('Hello', 'simple-chat-button'); ?>" value="<?php echo esc_attr($whatsapp_chat_text);?>"/>
                        </td>
                    </tr>
                <?php } elseif ($tab==='button-settings') { ?>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Button status', 'simple-chat-button'); ?> :</th>
                        <td>
                            <input type="checkbox" name="scb_button_status" id="scb_button_status" value="1" <?php checked('1', esc_attr($button_status));?>>
                            <span><?php echo esc_html__('Enabled', 'simple-chat-button'); ?></span>
                        <td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Button text', 'simple-chat-button'); ?> <small style="font-weight: 400"><?php echo esc_html__('(optional)','simple-chat-button'); ?></small> :</th>
                        <td>
                            <input type="text" name="scb_button_text" id="scb_button_text" placeholder="<?php echo esc_html__('Need Help?', 'simple-chat-button'); ?>" value="<?php echo esc_attr($button_text);?>"/>
                            <p class="description"><?php echo esc_html__('Leave this field empty to only show an icon.', 'simple-chat-button'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Desktop link type', 'simple-chat-button'); ?> :</th>
                        <td>
                            <select name="scb_desktop_link_type" id="scb_desktop_link_type" >
                                <option <?php selected(esc_attr($desktop_link_type), 'api'); ?> value="api"><?php echo esc_html__('WhatsApp Api', 'simple-chat-button'); ?></option>
                                <option <?php selected(esc_attr($desktop_link_type), 'web'); ?> value="web"><?php echo esc_html__('WhatsApp Web', 'simple-chat-button'); ?></option>
                                <option <?php selected(esc_attr($desktop_link_type), 'app'); ?> value="app"><?php echo esc_html__('Desktop App', 'simple-chat-button'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Open link in', 'simple-chat-button'); ?> :</th>
                        <td>
                            <select name="scb_button_target" id="scb_button_target" >
                                <option <?php selected(esc_attr($button_target), '_blank'); ?> value="_blank"><?php echo esc_html__('New Tab', 'simple-chat-button'); ?></option>
                                <option <?php selected(esc_attr($button_target), '_self'); ?> value="_self"><?php echo esc_html__('Current Tab', 'simple-chat-button'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Position', 'simple-chat-button'); ?> :</th>
                        <td>
                            <select name="scb_button_position" id="scb_button_position" >
                                <option <?php selected(esc_attr($button_position), 'right'); ?> value="right"><?php echo esc_html__('Bottom Right', 'simple-chat-button'); ?></option>
                                <option <?php selected(esc_attr($button_position), 'left'); ?> value="left"><?php echo esc_html__('Bottom Left', 'simple-chat-button'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Z-index', 'simple-chat-button'); ?> :</th>
                        <td>
                            <input type="number" name="scb_button_z_index" id="scb_button_z_index" min="0" max="999999999" step="1" value="<?php echo esc_attr($button_z_index) ?>" placeholder="100"/>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html__('Bottom margin', 'simple-chat-button'); ?> :</th>
                        <td>
                           <input type="number" name="scb_desktop_bottom_margin" id="scb_desktop_bottom_margin" min="0" max="100" step="1" value="<?php echo esc_attr($desktop_bottom_margin) ?>"/><span> <?php echo esc_html__('px (in Desktop)', 'simple-chat-button'); ?> </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"</th>
                        <td>
                            <input type="number" name="scb_tablet_bottom_margin" id="scb_tablet_bottom_margin" min="0" max="100" step="1" value="<?php echo esc_attr($tablet_bottom_margin) ?>"/><span> <?php echo esc_html__('px (in Tablet)', 'simple-chat-button'); ?> </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"></th>
                        <td>
                            <input type="number" name="scb_mobile_bottom_margin" id="scb_mobile_bottom_margin" min="0" max="100" step="1" value="<?php echo esc_attr($mobile_bottom_margin) ?>"/><span> <?php echo esc_html__('px (in Mobile)', 'simple-chat-button'); ?> </span>
                        </td>
                    </tr>
                <?php } elseif ($tab==='whatsapp-automation') { ?>
                    <div class="card" style="max-width:820px">
                        <h2><?php echo esc_html__('WhatsApp Automation', 'simple-chat-button'); ?></h2>
                        <p style="font-size:14px;line-height:1.6;">
                            <?php echo esc_html__('Still replying to WhatsApp chats manually? Upgrade your phone number to WhatsApp Business API and put it on autopilot.', 'simple-chat-button'); ?>
                        </p>

                        <p style="font-weight:600;margin-bottom:10px;">
                            <?php echo esc_html__('Create your account with WANotifier to get free access to the official WhatsApp Business API and:', 'simple-chat-button'); ?>
                        </p>

                        <ul style="list-style:disc;padding-left:20px;margin-top:0;">
                            <li><?php echo esc_html__('Send automated greetings and out-of-office replies', 'simple-chat-button'); ?></li>
                            <li><?php echo esc_html__('Create smart auto-responses for common questions', 'simple-chat-button'); ?></li>
                            <li><?php echo esc_html__('Setup and run a chatbot to handle FAQs 24/7', 'simple-chat-button'); ?></li>
                            <li><?php echo esc_html__('Capture leads in one place and send broadcasts later', 'simple-chat-button'); ?></li>
                            <li><?php echo esc_html__('And much more, without the need to stay online', 'simple-chat-button'); ?></li>
                        </ul>

                        <p>
                            <a class="button button-primary button-hero" href="<?php echo esc_url($wanotifier_url); ?>" target="_blank" rel="noopener noreferrer">
                                <?php echo esc_html__('Get Started for Free', 'simple-chat-button'); ?>
                            </a>
                        </p>

                        <p class="description" style="margin-top:10px;">
                            <em><?php echo esc_html__('When you sign up using the link above and later choose to upgrade, we earn a small commission at no extra cost to you — helping us support the development and maintenance of this plugin.', 'simple-chat-button'); ?></em>
                        </p>
                    </div>
                <?php } ?>
            </table>
            <?php
            if ($tab !== 'whatsapp-automation') {
                submit_button();
            }
            ?>
        </form>
    </div>
</div>