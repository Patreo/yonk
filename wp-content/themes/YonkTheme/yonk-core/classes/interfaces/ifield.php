<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_IField
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
interface Yonk_IField {

    /**
     * Create a text from list of attributes
     *
     * @return mixed
     */
    public function build_attributes();

    /**
     * Generate html for current field
     *
     * @param string $value
     * @return string
     */
    public function generate_html($value = '');
}