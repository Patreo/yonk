(function($) {

    $.fn.extend({
        gallery: function() {
            /**
             * Add Events to HTML elements
             *
             * @param $this
             */
            function addEvents($this) {
                $this.find('.gallery-media').click(function () {
                    openDialog($this);
                });

                $this.find('.gallery-view').mouseover(function() {
                    $(this).find('img').hover(function() {
                        $(this).css('border', 'solid 2px #ff0000');
                    }, function() {
                        $(this).css('border', 'solid 2px #fff');
                    });

                    $this.find('img').click(function() {
                        event.preventDefault();
                        if (confirm('You want delete this image?')) {
                            $(this).parent().remove();
                            build($this);
                        }
                    });
                });
            }

            /**
             * Create Image element
             *
             * @param imageUrl
             */
            function createImageComponent($this, url) {
                $this.find('.gallery-view').append('<div style="width:120px;height:120px;float:left;margin-right:10px;margin-bottom:10px;">' +
                        '<img style="width:120px;height:120px;border:solid 2px #fff;" src="' + url + '" alt="" />' +
                    '</div>');
            }

            /**
             * Open WordPress attachment window
             *
             * @returns {boolean}
             */
            function openDialog($this) {
                if (typeof wp.media !== 'undefined') {
                    var button = $this.find('.gallery-media');
                    _orig_send_attachment = wp.media.editor.send.attachment;

                    wp.media.editor.send.attachment = function(props, attachment){
                        createImageComponent($this, attachment.url);
                        build($this);
                    };

                    wp.media.editor.open(button);
                    return false;
                }
            }

            /**
             * Rebuild values from hidden field
             *
             * @param $this
             */
            function build($this) {
                var imageUrls = '';

                $this.find('.gallery-view').find('img').each(function(i, e) {
                    imageUrls += $(e).attr('src') + "~~~";
                });

                if (imageUrls.length >= 3) {
                    imageUrls = imageUrls.substring(0, imageUrls.length - 3);
                }

                $this.find("[type='hidden']").val(imageUrls);
            }

            return this.each(function() {
                var $this = $(this);

                var imageUrls = $this.find("[type='hidden']").val();
                if (imageUrls.length > 0) {
                    var images = imageUrls.split('~~~');
                    for (var i = 0; i < images.length; i++) {
                        createImageComponent($this, images[i]);
                    }
                }

                addEvents($this);
            });
        }
    });
})(jQuery);