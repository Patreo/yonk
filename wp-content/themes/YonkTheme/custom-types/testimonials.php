<?php

$testimonials = new Yonk_Post_Type('testimonial', array(
    'name' => 'Testimonial',
    'singular_name' => 'Testimonial',
    'taxonomies' => array()
));

$meta = new Yonk_Metabox(array(
    'name' => 'testimonial-meta',
    'title' => 'Cargo',
    'context' => 'side',
    'post_type' => array('testimonial')
));

$meta->add_field(array(
    'id' => 'cargo',
    'label' => 'Cargo',
    'type' => 'text',    
));