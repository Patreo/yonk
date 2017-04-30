<?php
defined('ABSPATH') or die('No script kiddies please!');

function qrcode_func($atts) {
	$a = shortcode_atts(array(
        'text'   => 'put your text here',
        'width'  => '150',
        'height' => '150'
    ), $atts);
	
	$url = 'https://api.qrserver.com/v1/create-qr-code/?size=' . $a['width'] . 'x' . $a['height'] . '&data=' . urlencode($a['text']);
?>
	<img src="<?php echo $url; ?>" alt="<?php $a['text']; ?>" />
<?php
}

add_shortcode('qrcode', 'qrcode_func');