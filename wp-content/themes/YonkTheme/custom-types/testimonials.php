<?php
defined('ABSPATH') or die('No script kiddies please!');

$testimonials = new Yonk_Post_Type('testimonial', array(
    'name' => 'Testimonial',
    'singular_name' => 'Testimonial',
    'taxonomies' => array()
));


add_action('cmb2_admin_init', 'testimonial_metabox');

/**
 * Hook in and register a metabox for the admin comment edit page.
 */
function testimonial_metabox() {

    /**
     * Sample metabox to demonstrate each field type included
     */
    $cmb = new_cmb2_box( array(
        'id'            => 'testimonial_metabox',
        'title'         => __('Cargo'),
        'context'       => 'side',
        'priority'      => 'low',
        'object_types'  => array('testimonial')
    ));

    $cmb->add_field( array(
        'id'   => 'cargo',
        'type' => 'text_medium'
    ));
}
