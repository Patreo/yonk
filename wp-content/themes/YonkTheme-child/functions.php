<?php

require_once (get_template_directory() . '/yonk-core/autoload.php');
require_once ('app/controllers/home.php');

function Yonk_admin_init() {
    $homeController = new HomeController();
    $homeController->create_menu();
}

add_action('admin_init', 'Yonk_admin_init');