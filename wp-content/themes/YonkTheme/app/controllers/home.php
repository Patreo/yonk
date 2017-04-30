<?php

class HomeController extends Yonk_Controller
{

    /**
     * Default Action for Home Controller
     */
    function index() {
        $template = $this->loadView("home/index");
        $template->set('name', 'Jonh Doe');

        get_header();
        $template->render();
        get_footer();
    }
}