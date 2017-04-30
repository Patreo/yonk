<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Controller
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Controller
{
    /**
     * Load Model
     *
     * @param $name
     * @return mixed
     */
    public function loadModel($name)  {
        require_once(get_stylesheet_directory() . '/app/models/' . strtolower($name) . '.php');
        $model = new $name;
        return $model;
    }

    /**
     * Load View
     *
     * @param $name
     * @return Yonk_View
     */
    public function loadView($name) {
        $view = new Yonk_View($name);
        return $view;
    }

    /**
     * Load Plugin
     *
     * @param mixed $name
     */
    public function loadPlugin($name) {
        require_once(get_stylesheet_directory() . '/app/plugins/' . strtolower($name) . '.php');
    }

    /**
     * Load Helper
     *
     * @param mixed $name
     */
    public function loadHelper($name)
    {
        require_once(get_stylesheet_directory() . '/app/helpers/' . strtolower($name) . '.php');
        $helper = new $name;
        return $helper;
    }

    /**
     * Redirect view to another URL
     *
     * @param mixed $location
     */
    public static function redirect($location)  {
        global $config;
        wp_redirect($config['base_url'] . $location, 301);
    }

}
