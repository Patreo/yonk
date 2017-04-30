<?php
defined('ABSPATH') or die('No script kiddies please!');
defined('WEATHER_API_KEY') or die('WEATHER_API_KEY is not founded in wp-config.php.');

/**
 * Class Yonk_Weather
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Weather extends WP_Widget {
	
	private $textDomain;

    /**
     * Constructor function for class Yonk_Weather
     */
	public function __construct() {
		$this->set_textDomain();	
		
		parent::__construct('Yonk_Weather', __('Weather', $this->textDomain),
			array('description' => __('Add a Weather widget', $this->textDomain)));
	}
	
	private function set_textDomain() {
		$theme = wp_get_theme();
		$this->textDomain = $theme->get("TextDomain");		
	}

    /**
     * Create widget frontend
     *
     * @param array $args
     * @param array $instance
     */
	public function widget($args, $instance) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', plugin_dir_url(__FILE__) . '/assets/js/jquery.min.js', false, '1.11.0', false);
	
		$title = apply_filters('widget_title', $instance['title']);
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if (!empty($title)) {
			echo $args['before_title'] . $title . $args['after_title'];
		}	

?>
	<div class="weather">
        <img src="" alt="" class="weather-img" />
        <div class="temperature"></div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $.getJSON("http://api.openweathermap.org/data/2.5/weather?q=<?php echo $instance['city']; ?>&units=<?php echo $instance['units']; ?>&APPID=<?php echo WEATHER_API_KEY ?>").done(function(data) {
                $('.weather .temperature').html("(" + data.main.temp + " C)");
                $('.weather .weather-img').attr("src", "http://openweathermap.org/img/w/" + data.weather[0].icon + ".png");
            });
        });
    </script>
<?php		
		
		echo $args['after_widget'];
	}

    /**
     * Widget Backend form
     *
     * @param array $instance
     * @return string|void
     */
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('New title', $this->textDomain);
		}

        if (isset($instance['city'])) {
            $city = $instance['city'];
        } else {
            $city = __('New York', $this->textDomain);
        }

        if (isset($instance['units'])) {
            $units = $instance['units'];
        } else {
            $units = __(' ªC', $this->textDomain);
        }
?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('city'); ?>"><?php _e('City:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('city'); ?>" name="<?php echo $this->get_field_name('city'); ?>" type="text" value="<?php echo esc_attr($city); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('units'); ?>"><?php _e('Units:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('units'); ?>" name="<?php echo $this->get_field_name('units'); ?>" type="text" value="<?php echo esc_attr($units); ?>" />
	</p>
<?php
	}

    /**
     * Updating widget replacing old instances with new
     *
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['city'] = (!empty($new_instance['city'])) ? strip_tags($new_instance['city']) : '';
		$instance['units'] = (!empty($new_instance['units'])) ? strip_tags($new_instance['units']) : '';
		return $instance;
	}
}

function Yonk_weather_load_widget() {
    register_widget('Yonk_Weather');
}

add_action('widgets_init', 'Yonk_weather_load_widget');