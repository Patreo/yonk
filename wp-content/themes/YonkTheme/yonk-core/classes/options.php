<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Options
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Options extends Yonk_Base {

    private $options;

    private $default = array(
        'name'   => 'my-setting-admin',
        'title'  => 'Settings Admin',
        'sections' => array(
            array(
                'name'  => 'my-setting-section-id',
                'title' => 'Enter your settings below:'
            ) // multiple arrays         
        ),
        'fields' => array(
            array(
                'name' => 'field_name',
                'title' => 'Fieldname',
                'type' => 'number', // number, text
                'section' => 'my-setting-section-id'                
            ) // multiple arrays
        )        
    );

    /**
     * Constructor function for class Yonk_Options
     *
     * @param $options
     */
    public function __construct($options = array()) {
        $this->merge($this->get_options(), $options);

        add_action('admin_menu', array(&$this, 'add_plugin_page'));
        add_action('admin_init', array(&$this, 'page_init'));
    }

	/**
	 * Create options page inside wordpress admin
     *
	 */
    public function add_plugin_page() {
        $options = $this->get_options();

        add_options_page(
            $options['title'], 
            $options['title'], 
            'manage_options', 
            $options['name'], 
            array(&$this, 'create_admin_page')
        );
    }

	/**
	 * Create admin page inside wordpress admin
     *
	 */
    public function create_admin_page() {
        $options = $this->get_options();
        $this->options = get_option($options['name'] . '_name'); ?>
        <div class="wrap">
            <h1><?php echo $options['title']; ?></h1>
            <form method="post" action="options.php">
            <?php
                settings_fields($options['name'] . '_group');  // This prints out all hidden setting fields
                do_settings_sections($options['name']);
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

	/**
	 * Initialize page controls
     *
	 */
    public function page_init() {
        $options = $this->get_options();
        
        register_setting($options['name'] . '_group', $options['name'] . '_name', 
            array($this, 'sanitize')
        );

        foreach ($options['sections'] as $section) {
            add_settings_section(
                $section['name'], 
                $section['title'], 
                array(&$this, 'print_section_info'), 
                $options['name']
            );  
        }

        foreach ($options['fields'] as $field) {
            add_settings_field(
                $field['name'],
                $field['title'],
                array(&$this, 'field_callback'), 
                $options['name'],
                $field['section'],
                $field
            );    
        }
    }

	/**
     * Sanitize controls for sql injection
     *
	 * @param $input
	 * @return array
	 */
    function sanitize($input) {
        $options = $this->get_options();
        $new_input = array();

        foreach ($options['fields'] as $field) {
            $name = $field['name'];
            $t = $field['type'];

            if (isset($input[$name])) {
                if ($t == 'number') {
                    $new_input[$name] = absint($input[$name]);
                } else {
                    $new_input[$name] = sanitize_text_field($input[$name]);
                } 
            }
        }
        return $new_input;
    }

	/**
     * Print section title
     *
	 * @param $args
	 */
    function print_section_info($args) {
        print $args['title']; 
    }

	/**
     * Field callback to generate controls inside page
     *
	 * @param $args
	 */
    function field_callback($args) {
        $options = $this->get_options();
        $name = $args['name'];
        $var = $options['name'] . '_name[' . $name . ']';        
        $t = 'text';
        $v = '';

        if (isset($args['type'])) {
            $t = $args['type'];
        }

        if (isset($this->options[$name])) {
            $v = esc_attr($this->options[$name]);
        }

        switch ($t) {
            case "textarea":
                echo sprintf('<textarea id="%s" name="%s" rows="6">%s</textarea>', $name, $var, $v);
                break;
            default:
                echo sprintf('<input type="%s" id="%s" name="%s" value="%s" />', $t, $name, $var, $v);            
                break;
        }
    }
}