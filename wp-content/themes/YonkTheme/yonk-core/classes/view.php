<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_View
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_View
{
    private $pageVars = array();
    private $filename;
    private $tmpl;

    /**
     * Constructor of View
     */
    public function __construct($template) {
        $this->filename = $template;

        $this->tmpl = new Yonk_Template();
        $this->tmpl->setPath(get_stylesheet_directory() . '/app/views/');
    }

    /**
     * Set variable to page view
     *
     * @param mixed $var
     * @param mixed $val
     */
    public function set($var, $val) {
        $this->pageVars[$var] = $val;
    }

    /**
     * Get variable in page view
     *
     * @param $var
     * @return null|mixed
     */
    public function get($var) {
        if (isset($this->pageVars[$var])) {
            return $this->pageVars[$var];
        }

        return null;
    }

    /**
     * Render page
     */
    public function render() {
        $this->tmpl->setVars($this->pageVars, true);
        $this->tmpl->display($this->filename . '.php');
    }

}