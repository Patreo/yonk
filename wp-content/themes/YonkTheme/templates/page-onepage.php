<?php /* Template Name: One Page Layout */ ?>
<?php get_header(); ?>

<?php
	global $post;

	$args = array(
		'post_type'      => 'page',
		'post_status'	 => 'publish',
    	'posts_per_page' => -1,
    	'post_parent'    => $post->ID,
    	'orderby'        => 'menu_order',
		'order'          => 'ASC'    	
	);

	$query = new WP_Query($args);

	if ($query->have_posts()): 
		while($query->have_posts()): $query->the_post();
			$page = get_post(get_the_ID()); ?>
        <article id="page-<?php echo $page->post_name; ?>" <?php post_class(); ?>>
            <?php get_template_part('page', $page->post_name); ?>
        </article>
        <?php 			
		endwhile;
	endif;
	wp_reset_query();
?>

<?php get_footer(); ?>
