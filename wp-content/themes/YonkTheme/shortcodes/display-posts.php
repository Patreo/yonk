<?php
defined('ABSPATH') or die('No script kiddies please!');

function display_posts_func($atts) {
	$a = shortcode_atts(array(
        'category'   => ''
    ), $atts);

	Yonk_Frontend::query('post', array('category_name' => $a['category'], 'orderby' => 'date', 'order' => 'DESC'), function() {
?>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<p class="date"><?php the_date(); ?></p>
			<p><?php the_excerpt(); ?></p>
		</div>
	</div>
	
<?php		
	});
}

add_shortcode('display-posts', 'display_posts_func');