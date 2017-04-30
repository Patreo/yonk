<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Field
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Field extends Yonk_Base implements Yonk_IField {
	public $id;
	public $label;
	public $type;
	public $default;
	public $attr;

	/**
	 * Constructor function for class Yonk_Field
	 *
	 * @param array $options
	 */
	public function __construct($type = 'text', $options = array()) {
	    parent::__construct($options);
	    $this->type = $type;
		$this->id = $this->get_option('id');
		$this->label = $this->get_option('label');
		$this->default = $this->get_option('default');
		$this->attr = $this->get_option('attributes', array());
	}

    /**
     * Generate attributes for html
     *
     * @return string
     */
    public function build_attributes() {
        if (empty($this->attr)) {
            return '';
        }

        $attr = '';
        foreach ($this->attr as $key => $value) {
            $attr .= $key . '="' . $value . '" ';
        }

        return $attr;
    }

    /**
     * Generate custom html for field
     *
     * @param string $value
     */
    public function generate_html($value = '') {
        return NULL;
    }
}