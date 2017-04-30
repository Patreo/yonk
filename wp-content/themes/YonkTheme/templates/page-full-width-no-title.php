<?php /* Template Name: Full Page w/o Title */ ?>
<?php get_header(); ?>
    <?php
        if (have_posts()):
            while (have_posts()): the_post();
                the_content();
            endwhile;
        else:
            get_template_part('content', 'none');
        endif;
    ?>
<?php get_footer(); ?>
