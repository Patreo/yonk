<?php
    defined('ABSPATH') or die('No script kiddies please!');

    wp_register_script('googlemaps', 'http://maps.googleapis.com/maps/api/js?pt_PT&libraries=places&key=' . GOOGLE_MAPS_V3_API_KEY . '&sensor=false', false, '3');
    wp_register_script('geocoding', YONK_URL . 'assets/js/gmap.geocode.js', array('googlemaps'), '1.0', false);
    wp_enqueue_script('googlemaps');
    wp_enqueue_script('geocoding');

    if (isset($value)) {
        $decoded = json_decode($value);
        $lat = $decoded->lat;
        $lng = $decoded->lng;

        $input_value = htmlspecialchars($value);
    } else {
        $lat = 0;
        $lng = 0;
        $input_value = "";
    }
?>

<tr>
    <th scope="row">
        <label for="<?php echo $name ?>"><?php echo $label ?></label>
    </th>
    <td>
        <input type="text" id="map_address_<?php echo $name ?>" class="widefat" style="margin-bottom:10px;" />
        <input type="hidden" id="<?php echo $name ?>" name="<?php echo $name ?>" value="<?php echo $input_value;  ?>" />
        <div id="map_<?php echo $name ?>" style="width:100%;height:320px;"></div>
    </td>
</tr>
<script type="text/javascript">
    function initMap_<?php echo $name ?>() {
        var map;
        var marker;
        var autocomplete;
        var latLng = { lat: <?php echo $lat ?>, lng: <?php echo $lng ?> };

        map = new google.maps.Map(document.getElementById('map_<?php echo $name ?>'), {
            center: latLng,
            zoom: 16,
            disableDefaultUI: true
        });

        map.addListener('click', function(e) {
            marker.setPosition(e.latLng);
            geocodeLatLng('<?php echo $name ?>', marker);
        });

        marker = new google.maps.Marker();
        marker.setPosition(latLng);
        marker.setMap(map);

        var input = document.getElementById('map_address_<?php echo $name ?>');
        autocomplete = new google.maps.places.Autocomplete(input, {
            types: ['geocode']
        });

        autocomplete.addListener('place_changed', function() {
            var location = autocomplete.getPlace().geometry.location;

            map.setCenter(location);
            marker.setPosition(location);
            geocodeLatLng('<?php echo $name ?>', marker);
        });

        if(navigator.geolocation && (latLng.lat == 0 && latLng.lng == 0)) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                latLng = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                map.setCenter(latLng);
                marker.setPosition(latLng);
            });
        }
    }

    $(document).ready(function() {
        initMap_<?php echo $name ?>();
    });
</script>