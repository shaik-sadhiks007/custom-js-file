<?php
/**
 * Plugin Name: Custom JS Text Field Plugin
 * Description: A plugin to add custom JavaScript to WordPress through an admin settings page.
 * Version: 1.0
 * Author: Sadhik
 */

// Add menu item for the plugin settings
function custom_js_plugin_menu() {
    add_menu_page('Custom JS Settings', 'Custom JS', 'manage_options', 'custom-js-plugin', 'custom_js_plugin_settings_page', '', 100);
}
add_action('admin_menu', 'custom_js_plugin_menu');

// Register settings
function custom_js_plugin_settings() {
    register_setting('custom_js_plugin_settings', 'custom_js_code');
}
add_action('admin_init', 'custom_js_plugin_settings');

// Settings page
function custom_js_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Custom JS Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('custom_js_plugin_settings'); ?>
            <?php do_settings_sections('custom_js_plugin_settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Custom JS Code</th>
                    <td><textarea name="custom_js_code" rows="10" cols="50"><?php echo esc_textarea(get_option('custom_js_code')); ?></textarea></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Enqueue admin script
function custom_js_plugin_admin_scripts() {
    wp_enqueue_script('custom-js-plugin-admin', plugin_dir_url(__FILE__) . 'admin.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'custom_js_plugin_admin_scripts');

// Enqueue custom JS script on the frontend
function custom_js_plugin_frontend_scripts() {
    // Ensure jQuery is loaded
    wp_enqueue_script('jquery');

    $custom_js_code = get_option('custom_js_code');
    if ($custom_js_code) {
        wp_add_inline_script('jquery', $custom_js_code);
    }
}
add_action('wp_enqueue_scripts', 'custom_js_plugin_frontend_scripts');
