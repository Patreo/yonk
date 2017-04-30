<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Page
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
abstract class Yonk_Page extends Yonk_Base {
    private $default = array(
        'name' => '_my_first_page',
        'title' => 'My First Page',
        'menu' => NULL
    );

    /**
     * Constructor Yonk_Page
     *
     * @param array $options
     */
    public function __construct($options = array()) {
        parent::__construct($options, $this->default);

        add_action('admin_menu', array(&$this, 'add_page_menu'));
        add_action('admin_init', array(&$this, 'page_init'));
    }

    /**
     *  Add menu or sub_menu to wordpress admin panel
     *  Hook into the 'add_page_menu' action
     */
    public function add_page_menu() {
        if ($this->get_option('menu') == NULL) {
            add_menu_page($this->get_option('title'), $this->get_option('title'), 'manage_options'
                , $this->get_option('name'), array(&$this, 'page_render'));
        } else {
            add_submenu_page($this->get_option('menu'), $this->get_option('title'), $this->get_option('title')
                , 'manage_options', $this->get_option('name'), array(&$this, 'page_render'));
        }
    }

    /**
     * Abstract function to render page contents
     * Hook into the 'add_menu_page' action
     *
     * @return mixed
     */
    public abstract function page_render();

    /**
     * Abstract function to initialize page controls
     * Hook into the 'admin_init' action
     *
     * @return mixed
     */
    public abstract function page_init();
}