<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Taxonomy
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */

class Yonk_Taxonomy extends Yonk_Base {

    private $post_type = array('post', 'page');
    private $taxonomy = '';

    /**
     * Constructor function for class Yonk_Taxonomy
     *
     * @param array $options
     */
    public function  __construct($taxonomy, $options = array()) {
        parent::__construct($options);
        $this->taxonomy = $taxonomy;
        $this->set_arguments();

        if ($this->get_option('post_type') != NULL) {
            $this->post_type = $this->get_option('post_type');
        }

        add_action('init', array(&$this, 'register_taxonomy'));
    }

    /**
     * Register taxonomy in WordPress init action
     */
    public function register_taxonomy() {
        if (is_array($this->post_type)) {
            register_taxonomy($this->taxonomy, $this->post_type, $this->get_options());
        } else {
            register_taxonomy($this->taxonomy, array($this->post_type), $this->get_options());
        }
    }

    /**
     * Create Arguments array and add Labels at same time
     *
     * @return array
     */
    private function set_arguments() {
        $args = array(
            'labels' => $this->labels($this->get_option('name')),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
        );

        // Set default values equals $args
        $this->merge($this->get_options(), $args);
    }

    /**
     * Create Labels array
     *
     * @return array
     */
    private function labels($name) {
        $plurals = Yonk_Util::pluralize(2, $name);

        $labels = array(
            'name' => sprintf(__('%s', $this->textDomain), $plurals),
            'singular_name' => sprintf(__('%s', $this->textDomain), $name),
            'menu_name' => sprintf(__('%s', $this->textDomain), $plurals),
            'all_items' => sprintf(__('All %s', $this->textDomain), $plurals),
            'new_item_name' => sprintf(__('Add %s', $this->textDomain), $name),
            'add_new_item' => sprintf(__('Add New %s', $this->textDomain), $name),
            'new_item' => sprintf(__('New %s', $this->textDomain), $name),
            'edit_item' => sprintf(__('Edit %s', $this->textDomain), $name),
            'update_item' => sprintf(__('Update %s', $this->textDomain), $name),
            'view_item' => sprintf(__('View %s', $this->textDomain), $name),
            'search_items' => sprintf(__('Search %s', $this->textDomain), $name),
            'not_found' => sprintf(__('Not %s found', $this->textDomain), $name),
            'parent_item' => sprintf(__('Parent %s', $this->textDomain), $name),
            'parent_item_colon' => sprintf(__('Parent %s:', $this->textDomain), $name),
            'separate_items_with_commas' => sprintf(__('Separate %s with commas', $this->textDomain), $plurals),
            'add_or_remove_items' => sprintf(__('Add or remove %s', $this->textDomain), $plurals),
            'popular_items' => sprintf(__('Popular %s', $this->textDomain), $plurals),
            'search_items' => sprintf(__('Search %s', $this->textDomain), $plurals),
            'no_terms' => sprintf(__('No %s', $this->textDomain), $plurals),
            'items_list' => sprintf(__('%s list', $this->textDomain), $plurals),
            'items_list_navigation' => sprintf(__('%s list navigation', $this->textDomain), $plurals),
        );

        return $labels;
    }

}
