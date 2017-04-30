<?php get_header(); ?>
<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
		<header class="page-header">
			<h1><?php printf(__('Search for: %s', 'blank'), get_search_query()); ?></h1>
		</header>
		<div id="search-results">
		<?php 
			if (have_posts()): 
				while (have_posts()): the_post(); 
					get_template_part('content', 'category');
				endwhile; 
		
				get_template_part('pagination');
			else:
				get_template_part('content', 'none');		
			endif; 
		?>	
		</div>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">			
		<section id="sidebar">
			<?php get_sidebar(); ?>
		</section>
	</div>
</div>
<?php get_footer(); ?>