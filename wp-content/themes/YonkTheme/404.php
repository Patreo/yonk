<?php 
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage YonkTheme
 * @since 1.0
 */
get_header(); ?>
<article id="page-404" role="article">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <header class="page-header">
                <h1><?php _e('Not Found', 'blank'); ?></h1>
            </header>
            <h3><?php _e('This is somewhat embarrassing, isn\'t it?', 'blank'); ?></h3>
            <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'blank'); ?></p>
            <?php get_search_form(); ?>
        </div>
    </div>
</article>
<?php get_footer(); ?>