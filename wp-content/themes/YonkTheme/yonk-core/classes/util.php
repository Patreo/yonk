<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Utility
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Util {
    /**
     * Pluralizes a word if quantity is not one.
     *
     * @param int $quantity Number of items
     * @param string $singular Singular form of word
     * @param string $plural Plural form of word; function will attempt to deduce plural form from singular if not provided
     * @return string Pluralized word if quantity is not one, otherwise singular
     */
    public static function pluralize($quantity, $singular, $plural=null) {
        if($quantity==1 || !strlen($singular)) return $singular;
        if($plural!==null) return $plural;

        $last_letter = strtolower($singular[strlen($singular)-1]);
        switch($last_letter) {
            case 'y':
                return substr($singular,0,-1).'ies';
            case 's':
                return $singular.'es';
            default:
                return $singular.'s';
        }
    }

    /**
     * Render metafield
     *
     * @param $type
     * @param null $vars
     */
    public static function field_render($type, $vars = NULL) {
        return Yonk_Util::renderPhpToString(YONK_PATH . 'meta/' . $type . '.php', $vars);
    }

    /**
     * Add template support for WordPress
     *
     * @param $file
     * @param null $vars
     * @return string
     */
    public static function renderPhpToString($file, $vars = NULL) {
        if (is_array($vars) && !empty($vars)) {
            extract($vars);
        }
        ob_start();
        include $file;
        return ob_get_clean();
    }

    /**
     * Load template part from wordpress
     *
     * @param [type] $template_name
     * @param [type] $part_name
     * @return void
     */
    public static function loadTemplatePart($template_name, $part_name = NULL) {
        ob_start();
        get_template_part($template_name, $part_name);
        $var = ob_get_contents();
        ob_end_clean();
        return $var;
    }
}