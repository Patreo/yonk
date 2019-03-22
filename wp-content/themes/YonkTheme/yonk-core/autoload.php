<?php
defined('ABSPATH') or die('No script kiddies please!');
define('YONK_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('YONK_URL', get_template_directory_uri() . '/yonk-core/');

if (!function_exists('Yonk_autoload')) {
    /**
     * Auto load for Yonk core framework
     *
     * @param string $class_name
     * @param string $base_path
     * @return void
     */
    function Yonk_autoload($class_name, $base_path = '') {
        $filename = str_replace('_', DIRECTORY_SEPARATOR, strtolower($class_name)) . '.php';

        if (strlen($base_path) == 0) {
            $file = YONK_PATH . $filename;
        } else {
            $file = $base_path . DIRECTORY_SEPARATOR .  $filename;
        }

        if (!file_exists($file)) {
            return FALSE;
        }

        include $file;
    }
}

Yonk_autoload('classes_interfaces_ifield');
Yonk_autoload('classes_config');
Yonk_autoload('classes_app');
Yonk_autoload('classes_model');
Yonk_autoload('classes_view');
Yonk_autoload('classes_template');
Yonk_autoload('classes_template.cache');
Yonk_autoload('classes_controller');
Yonk_autoload('classes_base');
Yonk_autoload('classes_db');
Yonk_autoload('classes_util');
Yonk_autoload('classes_navmenu');
Yonk_autoload('classes_frontend');
Yonk_autoload('classes_dashboard');
Yonk_autoload('classes_field');
Yonk_autoload('classes_selectfield');
Yonk_autoload('classes_metabox');
Yonk_autoload('classes_poststatus');
Yonk_autoload('classes_taxonomy');
Yonk_autoload('classes_posttypes');
Yonk_autoload('classes_options');
Yonk_autoload('classes_page');
Yonk_autoload('helpers_queries');
Yonk_autoload('helpers_frontend');
Yonk_autoload('helpers_admin');
Yonk_autoload('helpers_options');
Yonk_autoload('helpers_register');
Yonk_autoload('plugins_admin');
Yonk_autoload('plugins_optimize');
Yonk_autoload('plugins_pagenavi');
Yonk_autoload('functions');

do_action('Yonk_loaded'); 