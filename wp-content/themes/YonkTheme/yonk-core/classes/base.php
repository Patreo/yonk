<?php

/**
 * Class Yonk_Base
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Base {

    private $options = array();
    protected $textDomain = '';

    /**
     * Summary of __construct
     * @param mixed $options
     * @param mixed $default
     */
    public function __construct($options = array(), $default = array()) {
        $this->merge($options, $default);
        $this->set_textDomain();
    }

    /**
     * Set custom text domain
     */
    private function set_textDomain() {
        $theme = wp_get_theme();
        $this->textDomain = $theme->get("TextDomain");
    }

    /**
     * Merge new arguments with default array
     *
     * @param mixed $args
     * @param mixed $default
     */
    public function merge($args, $default = array()) {
        if (empty($default)) {
            $this->options = array_merge($this->options, $args);
        } else {
            $this->options = array_merge($default, $args);
        }
    }

    /**
     * Get option from classs constructor
     *
     * @param mixed $name
     * @param mixed $default
     * @return mixed
     */
    public function get_option($name, $default = NULL) {
        return (isset($this->options[$name]) ? $this->options[$name] : $default);
    }

    /**
     * Get all options registered
     *
     * @return array
     */
    public function get_options() {
        return $this->options;
    }
}