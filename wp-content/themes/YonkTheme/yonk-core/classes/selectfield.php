<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_SelectField
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_SelectField extends Yonk_Field implements Yonk_IField {

    private $choices = array();

	/**
	 * Constructor function for class Yonk_Field
	 *
	 * @param array $options
	 */
	public function __construct($options = array()) {
	    parent::__construct('select', $options);
		$this->choices = $this->get_option('choices', array());
	}

	/**
	 * Generate html for current field
	 *
	 * @param string $value
	 * @return string
	 */
	public function generate_html($value = '') {
		return NULL;
	}
}

