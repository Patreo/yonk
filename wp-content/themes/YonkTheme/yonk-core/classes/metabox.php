<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Metabox
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */

class Yonk_Metabox extends Yonk_Base {

    private $fields = array();
    
    private $default = array(
        'name' => '',
        'title' => '',
        'description' => '',
        'context' => 'advanced',
        'priority' => 'default',
        'template' => '',
        'post_type' => array('post'),
    );    

    /**
     * Constructor function for class Yonk_Metabox
     *
     * @param array $options
     */
    public function __construct($options = array()) {
        parent::__construct($options, $this->default);

        add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
        add_action('admin_footer', array(&$this, 'scripts'));
        add_action('save_post', array(&$this, 'save_post'));
    }

    /**
     * Add MetaBox to Post page
     */
    public function add_meta_boxes() {
        if (!is_array($this->get_option('post_type'))) {
            die('post_type must be an array.');
        }

        foreach ($this->get_option('post_type') as $screen) {
            add_meta_box($this->get_option('name'), __($this->get_option('title'), $this->textDomain)
                , array(&$this, 'add_meta_box_callback'), $screen, $this->get_option('context')
                , $this->get_option('priority'));
        }
    }

    /**
     * Add field to MetaBox
     *
     * @param $field
     */
    public function add_field($field) {
        if (is_array($field)) {
            if ($field['type'] == 'select') {
                $f = new Yonk_SelectField($field);
            } else {
                $f = new Yonk_Field($field['type'], $field);
            }
        } else {
            $f = $field;
        }

        $this->fields[] = $f;
    }

    /**
     * Create nonce field
     *
     * @param $name
     */
    private function create_nonce_field($name) {
        wp_nonce_field($name . '_data', $name . '_nonce');
    }

    /**
     * Create description on metabox
     */
    private function create_description() {
        if ($this->get_option('description') == NULL) {
            return;
        } else {
            echo '<p>' . $this->get_option('description') . '</p>';
        }
    }

    /**
     * Add MetaBox CallBack
     *
     * @param $post
     */
    public function add_meta_box_callback($post) {
        $name = $this->get_option('name');
        $template_name = $this->get_option('template');

        $this->create_nonce_field($name);
        $this->create_description();

        if (strlen($template_name) == 0) {
            $this->print_generated_html($post);
        } else {
            $templateFolderFounded = file_exists(YONK_PATH . 'templates/' . $template_name);

            if ($templateFolderFounded == TRUE) {
                echo Yonk_Util::renderPhpToString(YONK_PATH . 'templates/' . $template_name, $this->get_options());
            } else {
                echo Yonk_Util::renderPhpToString($template_name, $this->get_options());
            }
        }
    }

    /**
     * Save meta to post inside WordPress Database
     *
     * @param $post_id
     */
    public function save_post($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        $name = $this->get_option('name');
        $data = $name . '_data';

        if (get_post_type($post_id) == 'page') {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
        }

        $nonce = $_POST[$name . '_nonce'];
        if (!isset($nonce)) {
            return $post_id;
        }

        if (!wp_verify_nonce($nonce, $data)) {
            return $post_id;
        }

        $post = get_post($post_id);

        foreach ($this->fields as $field) {
            $control_id = $this->generated_control_id($field);
            $value = $_POST[$control_id];

            if (!isset($value)) {
                if ($field->type === 'checkbox') {
                    Yonk_Frontend::save_meta($field->id, '0', $post);                
                }
            } else {
                switch ($field->type) {
                    case 'email':
                        $value = sanitize_email($value);
                        break;
                    case 'text':
                        $value = sanitize_text_field($value);
                        break;
                    default:
                        break;
                }

                Yonk_Frontend::save_meta($field->id, $value, $post);
            }
        }
    }

    /**
     * Generate control ID and name for HTML and internal database names
     *
     * @param $field
     * @return string
     */
    private function generated_control_id($field) {
        return $this->get_option('name') . '_' . $field->id;
    }

    /**
     * Generate fields inside a Table and add to page
     *
     * @param $post
     */
    public function print_generated_html($post) {
        echo $this->generate_html($post, $this->fields);
    }

    /**
     * Get generated fields html and connect it to Post
     *
     * @param $post
     * @param $fields
     * @return string
     */
    public function generate_html($post, $fields) {
        $output = '';

        if (!isset($post)) {
            global $post;
        }

        if (count($fields) == 0) {
            return '';
        }

        foreach ($fields as $field) {
            $control_id = $this->generated_control_id($field);
            $value = Yonk_Frontend::get_meta($field->id, $post);

            $params = array(
                'name'       => $control_id,
                'label'      => $field->label,
                'options'    => $field->choices,
                'attributes' => $field->attributes,
                'value'      => ($value == NULL ? $field->default : $value)
            );

            $output .= Yonk_Util::field_render($field->type, $params);
        }

        return '<table class="form-table"><tbody>' . $output . '</tbody></table>';
    }

    /**
     * Hooks into WordPress' admin_footer function.
     * Adds scripts for media uploader.
     */
    public function scripts() {
        if (is_admin()) {
            wp_register_script('yonk-post-addmedia', YONK_URL . 'assets/js/admin-post-addmedia.js', array('jquery'), '1.0', true);
            wp_register_script('yonk-gallery', YONK_URL . 'assets/js/admin-gallery.js', array('jquery'), '1.0', true);
            wp_enqueue_script('yonk-post-addmedia');
            wp_enqueue_script('yonk-gallery');
        }
    }
}
