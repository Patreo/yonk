<?php get_header(); ?>
<!-- Customize this page like you want -->
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
        <div id="category-results">
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
            <?php get_sidebar('home'); ?>
        </section>
    </div>
</div>
<?php get_footer(); ?>