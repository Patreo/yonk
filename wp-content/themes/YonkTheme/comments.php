<?php
if (post_password_required()) {
	return;
}
?>

<div id="comments" class="comments-area">
<?php if (have_comments()): ?>
	<h3><?php echo number_format_i18n(get_comments_number()); ?> <?php _e('comments', 'blank'); ?>:</h3>	
	<?php
		wp_list_comments(array(
			'style'      => 'div',
			'short_ping' => false,
			'avatar_size'=> 80,
		));
	?>	
	<?php if (!comments_open()): ?>
		<p class="no-comments">
			<?php _e('Comments closed.', 'blank'); ?>
		</p>
	<?php endif; ?>
	<?php paginate_comments_links(); ?> 
<?php endif; // have_comments() ?>
<?php 
	if (comments_open()):
		$args = array(
			'label_submit'	=> 'Send',
			'title_reply'	=> 'Leave here a comment:'
		);
		comment_form($args); 
	endif;
?>
</div>
