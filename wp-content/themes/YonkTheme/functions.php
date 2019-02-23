<?php

require_once(dirname(__FILE__) . '/yonk-core/autoload.php');
require_once(dirname(__FILE__) . '/custom-types/team.php');
require_once(dirname(__FILE__) . '/custom-types/testimonials.php');

/**
 * Register two navigation menus, cam register more,
 * just put that on array.
 * Hook into the 'init' action
 */
function Yonk_nav_menus() {
	register_nav_menus(array(
		'primary' 	=> __('Navigation menu', 'blank'),
		'secondary' => __('Footer menu', 'blank'),
	));
}

add_action('init', 'Yonk_nav_menus');

/**
 * Register sidebars for home, pages and posts
 * Hook into the 'widgets_init' action
 */
function Yonk_register_siderbar() {
	register_sidebar(array(
		'name' => __('Home Sidebar', 'blank'),
		'id' => 'home',
		'before_widget' => '<aside id="%1$s" class="panel widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	));

	register_sidebar(array(
		'name' => __('Single Sidebar', 'blank'),
		'id' => 'single',
		'before_widget' => '<aside id="%1$s" class="panel widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	));

	register_sidebar(array(
		'name' => __('Page Sidebar', 'blank'),
		'id' => 'page',
		'before_widget' => '<aside id="%1$s" class="panel widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	));

	register_sidebar(array(
		'name' => __('Search Sidebar', 'blank'),
		'id' => 'search',
		'before_widget' => '<aside id="%1$s" class="panel widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	));

	register_sidebar(array(
		'name' => __('Category Sidebar', 'blank'),
		'id' => 'category',
		'before_widget' => '<aside id="%1$s" class="panel widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	));
}

add_action('widgets_init', 'Yonk_register_siderbar');

/**
 * Register custom scripts in frontend
 * Hook into the 'wp_enqueue_scripts' action
 */
function Yonk_register_scripts() {
	Yonk_register_jquery(get_template_directory_uri() . '/js/jquery.min.js');
	Yonk_register('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', '3.3.6');
	Yonk_register('scripts', get_template_directory_uri() . '/js/global.js', '1.0', array('jquery', 'bootstrap'));

	if (is_singular()) {
		wp_enqueue_script('comment-reply');
	}
}

add_action('wp_enqueue_scripts', 'Yonk_register_scripts');

/**
 * Register custom styles in frontend
 * Hook into the 'wp_enqueue_scripts' action
 */
function Yonk_register_styles() {
	Yonk_add_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', '3.3.6');
	Yonk_add_style('site', get_template_directory_uri() . '/css/site.css', '1.0');
	Yonk_add_style('style', get_template_directory_uri() . '/style.css', '1.0');
}

add_action('wp_enqueue_scripts', 'Yonk_register_styles', 0);

/**
 * Call template for category specified single
 * Hook into the 'single_template' action
 *
 * @param [type] $t
 * @return void
 */
function Yonk_single_category_template($t) {
    foreach ((array) get_the_category() as $cat) {
        if ($cat->category_parent == 0) {
            $cat_id = $cat->cat_ID;
        } else {
            $cat_id = $cat->category_parent;
        }

        if (file_exists(get_template_directory() . "/single-cat-{$cat_id}.php"))  {
            return get_template_directory() . "/single-cat-{$cat_id}.php"; 
        }
    }

    return $t;
}

add_filter('single_template', 'Yonk_single_category_template');

/**
 * Add new features to customizer
 * Hook into the 'customize_register' action
 * 
 * @param [type] $wp_customize
 * @return void
 */
function Yonk_theme_customizer($wp_customize) {

}
  
add_action('customize_register', 'Yonk_theme_customizer');

/**
 * Register Controllers for MVC usage
 * Hook into the 'after_setup_theme' action
 */
function Yonk_after_setup_theme() {
	load_theme_textdomain('blank', get_template_directory() . '/languages');

    global $config;
	$config['base_url'] = 'app/';

	// Default controller to load
	$config['default_controller'] = 'home';

	// Controller used for errors (e.g. 404, 500 etc)
	$config['error_controller'] = 'error';

	// Email used for send trace messages
	$config['admin_email'] = get_option('admin_email');

	// Database configuration
	$config['db_host'] = DB_HOST;
	$config['db_name'] = DB_NAME;
	$config['db_user'] = DB_USER;
	$config['db_password'] = DB_PASSWORD;

    if (!is_admin()) {
	    Yonk_Application::run();
    }
}

add_action('after_setup_theme', 'Yonk_after_setup_theme');
