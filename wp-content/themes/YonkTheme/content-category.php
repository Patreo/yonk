<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="meta">
                <p class="date"><?php the_date(); ?></p>
		        <?php the_category(); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <?php if (has_post_thumbnail()): ?>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                <?php the_post_thumbnail('thumbnail', array('class' => 'img-responsive')); ?>
            </div>
        <?php endif; ?>
        <div class="col-xs-12 col-sm-<?php echo (has_post_thumbnail() ? "8": "12"); ?> col-md-<?php echo (has_post_thumbnail() ? "8": "12"); ?> col-lg-<?php echo (has_post_thumbnail() ? "9": "12"); ?>">
            <?php the_excerpt(); ?>
            <a href="<?php the_permalink(); ?>" class="btn btn-default"><?php echo _e('Read more', 'blank'); ?></a>
        </div>
    </div>
</article>