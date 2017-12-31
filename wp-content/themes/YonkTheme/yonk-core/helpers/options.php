<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Returns the options array for Yonk
 *
 * @param [type] $name
 * @param boolean $default
 * @return void
 */
function Yonk_get_option($name, $default = false) {
    // Get the meta from the database
    $options = (get_option('yonk_options')) ? get_option('yonk_options') : null;

    // Return the option if it exists
    if (isset($options[$name])) {
        return apply_filters('Yonk_option_$name', $options[$name]);
    }

    // Return default if nothing else
    return apply_filters('Yonk_option_$name', $default);
}