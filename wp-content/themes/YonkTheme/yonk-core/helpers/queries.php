<?php
defined('ABSPATH') or die('No script kiddies please!');

if (!function_exists('Yonk_query')) {
	/**
	 * Create a new query and pass all arguments needed, at end can call
	 * a callback to build html from $post instance
	 *
	 * @param $post_type
	 * @param array $args
	 * @param null $loop_callback
	 * @return WP_Query
	 */
	function Yonk_query($post_type, $args = array(), $loop_callback = NULL) {
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;

		$default = array(
			'post_type' => $post_type,
			'post_status' => 'publish',
			'posts_per_page' => 10,
			'paged' => $paged,
			'has_password' => false,
			'orderby' => 'ID',
			'order' => 'DESC',
		);

		$args = array_merge($default, $args);
		$query = new WP_Query($args);

		if (isset($loop_callback)) {
            global $post;
			while ($query->have_posts()) {
				$query->the_post();
				call_user_func($loop_callback, $post, $query);
			}

			wp_reset_postdata();
		}

		return $query;
	}
}