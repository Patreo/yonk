<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <header class="page-header">
                <h1><?php the_title(); ?></h1>
            </header>
			<?php the_content(); ?>
		</div>
	</div>
</article>