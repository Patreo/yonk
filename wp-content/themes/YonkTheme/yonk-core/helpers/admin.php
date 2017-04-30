<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Helper_Admin
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Helper_Admin {
    /**
     * Create an Admin Notice message
     *
     * @param $message
     * @param bool $is_error
     */
    public static function admin_notice($message, $is_error = false) {
        if ($is_error) {
            echo '<div class="error">';
        }
        else {
            echo '<div class="updated">';
        }

        echo '<p><strong>' . $message . '</strong></p>';
        echo '</div>';
    }
}