<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <header class="page-header">
                <h1><?php the_title(); ?></h1>
            </header>
            <div class="meta">
                <p class="date"><?php the_date(); ?></p>
	            <?php the_category(); ?>
            </div>
        </div>
    </div>
    <?php if (has_post_thumbnail()): ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">
                <?php
                    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                    $url = $thumb['0'];
                ?>
                <img src="<?php echo $url; ?>" alt="<?php the_title(); ?>" alt="<?php the_title(); ?>" style="width:100%" />
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php the_content(); ?>
        </div>
    </div>
</article>
<?php echo get_template_part('author'); ?>

