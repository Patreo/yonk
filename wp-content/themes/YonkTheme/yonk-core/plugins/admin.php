<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Custom admin scripts.
 * Hook into the 'admin_enqueue_scripts' action
 * Hook into the 'login_enqueue_scripts' action
 */
function Yonk_admin_scripts() {
    wp_enqueue_style('yonk-admin', YONK_URL . 'assets/css/custom-admin.css');
}

add_action('admin_enqueue_scripts', 'Yonk_admin_scripts');
add_action('login_enqueue_scripts', 'Yonk_admin_scripts');

/**
 * Remove WordPress logo from admin bar
 * Hook into the 'wp_before_admin_bar_render' action
 */
function Yonk_adminbar_remove_logo() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}

add_action('wp_before_admin_bar_render', 'Yonk_adminbar_remove_logo');

/**
 * Change copyright of admin footer
 * Hook into the 'admin_footer_text' action
 */
function Yonk_change_admin_footer() {
    $theme =  wp_get_theme();
    echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Designed by <a href="' . $theme->get('ThemeURI') . '" target="_blank">' . $theme->get('Template') .'</a></p>';
}

add_filter('admin_footer_text', 'Yonk_change_admin_footer');

/**
 * Remove welcome panel from dashboard
 * Hook into the 'welcome_panel' action
 */
remove_action('welcome_panel', 'wp_welcome_panel');

/**
 * Remove dashboard widgets from WordPress Admin Home Panel
 * Hook into the 'admin_init' action
 */
function Yonk_remove_dashboard_widgets() {
    remove_meta_box('yoast_db_widget', 'dashboard', 'normal');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_primary', 'dashboard', 'normal');
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
}

add_action('admin_init', 'Yonk_remove_dashboard_widgets');

/**
 * Remove some unnecessary widgets from widget panel
 * Hook into the 'widgets_init' action
 */
function Yonk_remove_widget() {
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
}

add_action('widgets_init', 'Yonk_remove_widget');

/* Capable to use shortcodes to Widget Text */
add_filter('widget_text', 'do_shortcode');

