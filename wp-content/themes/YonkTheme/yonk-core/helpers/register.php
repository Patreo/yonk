<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Register jQuery script for base theme
 *
 * @param $path
 */
function Yonk_register_jquery($path) {
    wp_deregister_script('jquery');
	wp_register_script('jquery', $path, false, '2.1.1', false);
	wp_enqueue_script('jquery');
}

/**
 * Register custom scripts for base theme
 *
 * @param $name
 * @param $path
 * @param $version
 */
function Yonk_register($name, $path, $version = '1.0', $dependencies = array()) {
    wp_register_script($name, $path, $dependencies, $version, true);
	wp_enqueue_script($name);
}

/**
 * Register custom styles for base theme
 *
 * @param $name
 * @param $path
 * @param $version
 */
function Yonk_add_style($name, $path, $version) {
    wp_register_style($name, $path, false, $version, 'all');
	wp_enqueue_style($name);
}

/**
 * Remove custom styles from base theme
 *
 * @param $name
 */
function Yonk_remove_style($name) {
    wp_dequeue_style($name);
	wp_deregister_style($name);
}