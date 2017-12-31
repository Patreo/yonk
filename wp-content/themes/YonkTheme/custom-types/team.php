<?php
defined('ABSPATH') or die('No script kiddies please!');

$team = new Yonk_Post_Type('team', array(
    'name'          => 'Team',
    'singular_name' => 'Team',
    'taxonomies'    => array(),
    'supports'      => array('title', 'editor', 'thumbnail')
));


$meta = new Yonk_Metabox(array(
    'name' => 'team-meta',
    'title' => 'Equipa',
    'post_type' => array('team')
));

$meta->add_field(array('id' => 'cargo', 'label' => 'Cargo', 'type' => 'text' ));
$meta->add_field(array('id' => 'facebook', 'label' => 'Facebook', 'type' => 'text' ));
$meta->add_field(array('id' => 'instagram', 'label' => 'Instagram', 'type' => 'text' ));
$meta->add_field(array('id' => 'linkedin', 'label' => 'LinkedIn', 'type' => 'text' ));
$meta->add_field(array('id' => 'twitter', 'label' => 'Twitter', 'type' => 'text' ));
