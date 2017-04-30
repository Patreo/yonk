<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Post_Status
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Post_Status extends Yonk_Base {
    private $default = array(
        'name' => '',
        'post_type' => array('post'),
    );

    private $post_status = '';

    /**
     * Constructor function for class Yonk_Post_Status
     *
     * @param $options
     */
    public function  __construct($post_status, $options = array()) {
        parent::__construct($options, $this->default);
        $this->post_status = $post_status;
        $this->set_arguments();

        add_action('init', array(&$this, 'register_post_status'));
        add_action('admin_head', array(&$this, 'meta_tags'));
        add_action('admin_enqueue_scripts', array(&$this, 'scripts'));
    }

    /**
     * Register custom post status in WordPress init action
     */
    public function register_post_status() {
        register_post_status($this->post_status, $this->get_options());
    }

    /**
     * Register custom JavaScript in head
     */
    public function meta_tags() {
        if (!is_admin()) {
            return;
        }

        $screen = get_current_screen();

        if (!in_array($screen->post_type, $this->get_option('post_type'))) {
            return;
        }

        global $post;
        if (!isset($post)) {
            return;
        }

        if ($post->post_type == $screen->post_type) {
            $default = array(
                'post_status' => $this->post_status,
                'label' => $this->get_option('name'),
                'post_types' => $this->get_option('post_type'),
                'selected' => ($post->post_status == $this->post_status),
            );

            echo "<script type=\"text/javascript\">";
            echo "	$(document).ready(function() {";
            echo "		$.postStatus.add(" . json_encode($default) . ");";
            echo "	});";
            echo "</script>";
        }
    }

    /**
     * Register custom javascript scripts
     *
     */
    public function scripts() {
        if (is_admin()) {
            wp_deregister_script('jquery');
            wp_register_script('jquery', YONK_URL . 'assets/js/jquery.min.js', null, '1.11.0', false);
            wp_register_script('yonk-custom-status', YONK_URL . 'assets/js/admin-post-status.js', array('jquery'), '1.0', true);
            wp_enqueue_script('jquery');
            wp_enqueue_script('yonk-custom-status');
        }
    }

    /**
     * Create Arguments array
     *
     * @return array
     */
    private function set_arguments() {
        $args = array(
            'label' => sprintf(__('%s', $this->textDomain), $this->get_option('name')),
            'label_count' => _n_noop($this->get_option('name') . ' (%s)',$this->get_option('name') . 's (%s)', $this->textDomain),
        );

        $this->merge($args);
    }
}