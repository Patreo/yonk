<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Dashboard_Widget
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
abstract class Yonk_Dashboard_Widget {
	private $title;

	/**
	 * Constructor function for class Yonk_Dashboard_Widget
	 *
	 * @param $title
	 */
	public function __construct($title = 'Widget') {
		$this->title = $title;
		add_action('wp_dashboard_setup', array(&$this, 'add_dashboard_widget'));
	}

	/**
	 *  Add dashboard widget
	 */
	public function add_dashboard_widget() {
		wp_add_dashboard_widget(sanitize_title($this->title), $this->title, array(&$this, 'render'));
	}

	/**
     * Abstract function for render Dashboard_Widget
     *
	 * @return mixed
	 */
	public abstract function render();
}