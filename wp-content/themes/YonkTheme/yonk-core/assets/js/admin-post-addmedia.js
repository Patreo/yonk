(function($) {
	if (typeof wp.media !== 'undefined') {
		var _custom_media = true,
		_orig_send_attachment = wp.media.editor.send.attachment;
		$('.metabox-media').click(function(e) {
			var button = $(this);
			var id = button.attr('id').replace('_button', '');

            wp.media.editor.send.attachment = function(props, attachment){
                if (_custom_media) {
					$("#" + id).val(attachment.url);
				} else {
					return _orig_send_attachment.apply(this, [props, attachment]);
				};
			}
			wp.media.editor.open(button);
			return false;
		});
		$('.add_media').on('click', function(){
			_custom_media = false;
		});
	}
})(jQuery);