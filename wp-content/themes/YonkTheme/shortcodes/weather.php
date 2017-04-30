<?php
defined('ABSPATH') or die('No script kiddies please!');
defined('WEATHER_API_KEY') or die('WEATHER_API_KEY is not founded in wp-config.php.');

function weather_func($atts) {
    $a = shortcode_atts(array(
        'city'   => 'New York',
        'units'  => 'metric'
    ), $atts);

    wp_deregister_script('jquery');
    wp_register_script('jquery', plugin_dir_url(__FILE__) . '/assets/js/jquery.min.js', false, '1.11.0', false);
    ?>

    <div class="weather">
        <img src="" alt="" class="weather-img" />
        <div class="temperature"></div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $.getJSON("http://api.openweathermap.org/data/2.5/weather?q=<?php echo $a['city']; ?>&units=<?php echo $a['units']; ?>&APPID=<?php echo WEATHER_API_KEY ?>").done(function(data) {
                $('.weather .temperature').html("(" + data.main.temp + " C)");
                $('.weather .weather-img').attr("src", "http://openweathermap.org/img/w/" + data.weather[0].icon + ".png");
            });
        });
    </script>

    <?php
}

add_shortcode('weather', 'weather_func');