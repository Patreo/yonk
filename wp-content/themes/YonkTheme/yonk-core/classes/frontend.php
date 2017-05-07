<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Frontend
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Frontend {

	/**
	 * Create a new query and pass all arguments needed, at end can call
	 * a callback to build html from $post instance
	 *
	 * @param $post_type
	 * @param array $args
	 * @param null $loop_callback
	 * @return WP_Query
	 */
	public static function query($post_type, $args = array(), $loop_callback = NULL) {
		return Yonk_query($post_type, $args, $loop_callback);
	}

	/**
	 * Get value of post metadata
	 *
	 * @param $name
	 * @param $post
	 * @return mixed
	 */
	public static function get_meta($name, $post = NULL) {
		if (!isset($post)) {
			global $post;
		}

		return get_post_meta($post->ID, $name, true);
	}

	/**
	 * Save value to post metadata
	 *
	 * @param $name
	 * @param $value
	 * @param null $post
	 * @return bool|int
	 */
	public static function save_meta($name, $value, $post = NULL) {
		if (!isset($post)) {
			global $post;
		}

		return update_post_meta($post->ID, $name, $value);
	}

    /**
	 * Get all attachments associated with 
	 * Post ID
	 *
	 * @param null $post
	 * @return array
	 */
	function get_attachments($post = NULL) {
		if (!isset($post)) {
			global $post;
		}

		$args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $post->ID,
			'orderby' => 'menu_order',
			'order' => 'ASC',
		);

		$attachments = get_posts($args);
		return $attachments;
	}

	/**
	 * Get related posts linked with same topics 
	 * of loaded post
	 *
	 * @param int $qty
	 */
	function get_related_posts($qty = 4, $post = NULL) {
		if (!isset($post)) {
			global $post;
		}

		$tags = wp_get_post_tags($post->ID);
		$tag_id = array();

		foreach ($tags as $tag) {
			$tag_id[] = $tag->term_id;
		}

		$args = array(
			'tag__in' => $tag_id,
			'post__not_in'  => array($post->ID),
			'posts_per_page' => $qty,
			'post_type' => 'post',
			'ignore_sticky_posts' => 1
		);

		$posts = new WP_Query($args);
		echo '<div class="row">';

		if ($posts->have_posts()) {
			while ($posts->have_posts()) {
				$posts->the_post();

				if (has_post_thumbnail()) {
					$img = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
				} else {
                    $img = '';
                }

				echo '<div class="col-md-' . (12 / qty) . ' col-lg-'. (12 / qty) . '">';
				echo '  <img src="' . $img . '" alt="' . the_title() . '" />';
				echo '	<span class="text">';
				echo '		<h4><a href="' . the_permalink() . '">' . the_title() . '</a></h4>';
				echo '	</span>';
				echo '</div>';
			}
		}

		echo '</div>';
		wp_reset_postdata();
	}
}