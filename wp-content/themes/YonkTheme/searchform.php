<?php
/**
 * The template for displaying search forms in NARGA
 * 
 * @package WordPress
 * @subpackage YonkTheme
 * @since 1.0
 */
?>
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url(home_url('/')); ?>">
	<div class="form-group">
		<label for="s"><?php _e('Search:', 'blank'); ?></label>
		<input type="text" class="form-control" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php _e('Search here', 'blank'); ?>" />
	</div>
	<button type="submit" id="searchsubmit" class="btn btn-primary"><?php echo esc_attr_x('Search', 'submit button', 'blank'); ?></button>	
</form>