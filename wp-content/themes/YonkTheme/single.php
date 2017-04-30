<?php get_header(); ?>
<div class="row">
	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
        <?php
            if (have_posts()):
                while (have_posts()): the_post();
                    get_template_part('content', get_post_format());
                    comments_template('', true);
                endwhile;
            else:
                get_template_part('content', 'none');
            endif;
        ?>
	</div>	
	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">			
		<section id="sidebar">
			<?php get_sidebar(); ?>
		</section>
	</div>
</div>
<?php get_footer(); ?>