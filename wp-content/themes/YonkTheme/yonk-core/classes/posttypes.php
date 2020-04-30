<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Post_Type
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Post_Type extends Yonk_Base
{

    private $post_type = '';

    /**
     * Constructor function for class Yonk_Post_Type
     *
     * @param $options
     */
    public function __construct($post_type, $options = array())
    {
        parent::__construct($options);
        $this->post_type = $post_type;
        $this->set_arguments();

        add_action('init', array(&$this, 'register_post_type'));
        add_action('admin_head', array(&$this, 'help'));
    }

    /**
     * Register custom post type in WordPress init action
     */
    public function register_post_type()
    {
        register_post_type($this->post_type, $this->get_options());
    }

    /**
     * Create arguments array and add Labels at same time
     *
     * @return array
     */
    private function set_arguments()
    {
        $args = array(
            'labels' => $this->labels($this->get_option('name')),
            'supports' => array('title', 'editor', 'thumbnail'),
            'taxonomies' => array('post_tag'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => false,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'rewrite' => true,
            'query_var' => true,
            'capability_type' => 'post',
        );

        // Set default values equals $args
        $this->merge($this->get_options(), $args);
    }

    /**
     * Create Labels array
     *
     * @return array
     */
    private function labels($name)
    {
        $plurals = Yonk_Util::pluralize(2, $name);

        $labels = array(
            'name' => sprintf(__('%s', $this->textDomain), $plurals),
            'singular_name' => sprintf(__('%s', $this->textDomain), $name),
            'menu_name' => sprintf(__('%s', $this->textDomain), $plurals),
            'name_admin_bar' => sprintf(__('%s', $this->textDomain), $name),
            'archives' => sprintf(__('%s Archives', $this->textDomain), $name),
            'parent_item_colon' => sprintf(__('Parent %s', $this->textDomain), $name),
            'all_items' => sprintf(__('All %s', $this->textDomain), $plurals),
            'add_new_item' => sprintf(__('Add New %s', $this->textDomain), $name),
            'add_new' => sprintf(__('Add %s', $this->textDomain), $name),
            'new_item' => sprintf(__('New %s', $this->textDomain), $name),
            'edit_item' => sprintf(__('Edit %s', $this->textDomain), $name),
            'update_item' => sprintf(__('Update %s', $this->textDomain), $name),
            'view_item' => sprintf(__('View %s', $this->textDomain), $name),
            'search_items' => sprintf(__('Search %s', $this->textDomain), $name),
            'not_found' => sprintf(__('Not %s found', $this->textDomain), $name),
            'not_found_in_trash' => sprintf(__('Not %s found in Trash', $this->textDomain), $name),
        );

        return $labels;
    }

    /**
     * Create Taxonomy to current Post Type
     *
     * @param $taxonomy
     * @param $options
     * @return Yonk_Taxonomy
     */
    public function add_taxonomy($taxonomy, $options)
    {
        $default = array(
            'post_type' => array($this->post_type)
        );

        $tax = new Yonk_Taxonomy($taxonomy, array_merge($default, $options));
        return $tax;
    }

    /**
     * Create Post Status to current Post Type
     *
     * @param $post_status
     * @param $options
     * @return Yonk_Post_Status
     */
    public function add_post_status($post_status, $options)
    {
        $default = array(
            'post_type' => array($this->post_type)
        );

        $status = new Yonk_Post_Status($post_status, array_merge($default, $options));
        return $status;
    }

    /**
     * Create MetaBox to current Post Type
     *
     * @param $name
     * @param $options
     * @return Yonk_Metabox
     */
    public function create_metabox($name, $options)
    {
        $default = array(
            'name' => $name,
            'post_type' => array($this->post_type)
        );

        $metabox = new Yonk_Metabox(array_merge($default, $options));
        return $metabox;
    }

    /**
     * Create Help screen
     *
     * @param array $tabs
     * @return void
     */
    public function help($tabs = array(array('id' => '', 'title' => '', 'content' => '')))
    {
        $screen = get_current_screen();

        if ($this->post_type != $screen->post_type) {
            return;
        } else {
            if (!isset($tabs) || $tabs == NULL) {
                return;
            } else {
                foreach ($tabs as $tab) {   
                    $screen->add_help_tab($tab);
                }
            }
        }
    }
}
