if (window, $) {
	$.extend($.postStatus = {}, {
		add: function(config) {
			$("#post_status").append("<option value=\"" + config.post_status + "\"" + (config.selected ? " selected=\"selected\"" : "") + ">" + config.label + "</option>");
			if (config.selected) {
				$("#post-status-display").html(" <span id=\"post-status-display\">" + config.label + "</span>");		
			}            
		}
	});
}