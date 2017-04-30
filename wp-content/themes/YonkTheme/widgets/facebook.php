<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Facebook
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Facebook extends WP_Widget {
	
	private $textDomain;

    /**
     * Constructor function for class Yonk_Facebook
     */
	public function __construct() {
		$this->set_textDomain();	
		
		parent::__construct('Yonk_Facebook', __('Facebook', $this->textDomain),
			array('description' => __('Add a Facebook widget', $this->textDomain)));
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
		$title = apply_filters('widget_title', $instance['title']);
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if (!empty($title) && $title != __('New Title', $this->textDomain)) {
			echo $args['before_title'] . $title . $args['after_title'];
		}	

		$url = $instance['url'];
        $title = $instance['title'];
?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_PT/sdk.js#xfbml=1&version=v2.5&appId=905119706222097";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class="fb-page" 
		data-href="<?php echo $url ?>" 
		data-small-header="false" 
		data-adapt-container-width="true" 
		data-hide-cover="false" 
		data-show-facepile="true">
		<div class="fb-xfbml-parse-ignore">
			<blockquote cite="<?php echo $url ?>">
				<a href="<?php echo $url ?>"><?php echo $title ?></a>
			</blockquote>
		</div>
	</div>
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
			$title = __('New Title', $this->textDomain);
		}
		
		if (isset($instance['url'])) {
			$url = $instance['url'];
		} else {
			$url = __('http://facebook.com/', $this->textDomain);
		}
?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('URL:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" />
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
		$instance['url'] = (!empty($new_instance['url'])) ? strip_tags($new_instance['url']) : '';
		return $instance;
	}
}

function Yonk_facebook_load_widget() {
    register_widget('Yonk_Facebook');
}

add_action('widgets_init', 'Yonk_facebook_load_widget');