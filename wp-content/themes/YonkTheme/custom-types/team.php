<?php
defined('ABSPATH') or die('No script kiddies please!');

$team = new Yonk_Post_Type('team', array(
    'name'          => 'Team',
    'singular_name' => 'Team',
    'taxonomies'    => array(),
    'supports'      => array('title', 'editor', 'thumbnail')
));


add_action('cmb2_admin_init', 'team_metabox');

/**
 * Hook in and register a metabox for the admin comment edit page.
 */
function team_metabox() {

    /**
     * Sample metabox to demonstrate each field type included
     */
    $cmb = new_cmb2_box( array(
        'id'           => 'team_metabox',
        'title'        => __('Team'),
        'object_types' => array('team'),
    ));

    $cmb->add_field( array(
        'name' => 'Cargo',
        'id'   => 'cargo',
        'type' => 'text_medium'
    ));

    $cmb->add_field( array(
        'name' => 'Facebook',
        'id'   => 'facebook_url',
        'type' => 'text_url',
        'desc' => 'https://www.facebook.com/{username}',
        'protocols' => array( 'http', 'https')
    ));

    $cmb->add_field( array(
        'name' => 'Instagram',
        'id'   => 'instagram_url',
        'type' => 'text_url',
        'desc' => 'https://www.instagram.com/{username}',
        'protocols' => array( 'http', 'https')
    ));

    $cmb->add_field( array(
        'name' => 'LinkedIn',
        'id'   => 'linkedin_url',
        'type' => 'text_url',
        'desc' => 'https://www.linkedin.com/in/{username}',
        'protocols' => array( 'http', 'https')
    ));

    $cmb->add_field( array(
        'name' => 'Twitter',
        'id'   => 'twitter_url',
        'type' => 'text_url',
        'desc' => 'https://www.twitter.com/{username}',
        'protocols' => array( 'http', 'https')
    ));
}
