<?php
defined('ABSPATH') or die('No script kiddies please!');
defined('GOOGLE_MAPS_V3_API_KEY') or die('GOOGLE_MAPS_V3_API_KEY is not founded in wp-config.php.');

/**
 * Shortcode function for google maps
 *
 * @see [map lat="0" lng="0" zoom="10"]Hello World[/map]
 * @param $atts
 * @param null $content
 */
function map_func($atts, $content = null) {
    $a = shortcode_atts(array(
        'id'     => 'map_0',
        'lat'    => '0',
        'lng'    => '0',
        'zoom'   => '8',
        'width'  => '100%',
        'height' => '500px'
    ), $atts);

    wp_register_script('googlemaps', 'http://maps.googleapis.com/maps/api/js?pt_PT&key=' . GOOGLE_MAPS_V3_API_KEY . '&sensor=false', false, '3');
    wp_enqueue_script('googlemaps');
?>
    <style type="text/css">
        #<?php echo $a['id'] ?> {
            width: <?php echo $a['width'] ?>;
            height: <?php echo $a['height'] ?>;
        }
    </style>

    <div id="<?php echo $a['id'] ?>"></div>

    <script type="text/javascript">
        var <?php echo $a['id'] ?>;

        function initMap_<?php echo $a['id'] ?>() {
            var myLatLng_<?php echo $a['id'] ?> = { lat: <?php echo $a['lat'] ?>, lng: <?php echo $a['lng'] ?> };

            <?php echo $a['id'] ?> = new google.maps.Map(document.getElementById('<?php echo $a['id'] ?>'), {
                zoom: <?php echo $a['zoom'] ?>,
                center: myLatLng_<?php echo $a['id'] ?>
            });

            var marker_<?php echo $a['id'] ?> = new google.maps.Marker({
                position: myLatLng_<?php echo $a['id'] ?>,
                map: <?php echo $a['id'] ?>,
                title: '<?php echo (isset($content) ? $content : '') ?>'
            });
        }

        $(function () {
            if (window.google && google.maps) {
                google.maps.event.addDomListener(window, 'load', initMap_<?php echo $a['id'] ?>);
            }
        });


    </script>
<?php
}

add_shortcode('map', 'map_func');