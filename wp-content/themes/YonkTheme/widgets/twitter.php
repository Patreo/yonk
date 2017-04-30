<?php
defined('ABSPATH') or die('No script kiddies please!');
include_once('lib/codebird.php');

/**
 * Class Yonk_Twitter
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Twitter extends WP_Widget {

    private $textDomain;

    /**
     * Constructor function for class Yonk_Twitter
     */
    public function __construct() {
        $this->set_textDomain();

        parent::__construct('Yonk_Twitter', __('Twitter', $this->textDomain),
            array('description' => __('Add a Twitter widget', $this->textDomain)));
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
        global $cb;
        $consumer_key = $instance['consumer_key'];
        $consumer_secret = $instance['consumer_secret'];
        $access_token = $instance['access_token'];
        $access_secret = $instance['access_secret'];

        if (strlen($consumer_key) == 0) {
            return;
        }

        Codebird\Codebird::setConsumerKey($consumer_key, $consumer_secret);
        $cb = Codebird\Codebird::getInstance();
        $cb->setToken($access_token, $access_secret);

        $tweets = $this->get_tweets($args['widget_id'], $instance);
        if(!empty($tweets['tweets']) AND empty($tweets['tweets']->errors)) {
            $title = apply_filters('widget_title', $instance['title']);
            // before and after widget arguments are defined by themes
            echo $args['before_widget'];
            if (!empty($title)) {
                echo $args['before_title'] . $title . $args['after_title'];
            }

            $user = current($tweets['tweets']);
            $user = $user->user;
?>
            <div class="twitter-profile">
                <img src="<?php echo $user->profile_image_url; ?>">
                <h4><a class="heading-text-color" href="http://twitter.com/<?php echo $user->screen_name; ?>"><?php echo $user->screen_name; ?></a></h4>
                <div class="description content"><?php echo $user->description; ?></div>
            </div>

            <ul class="twitter-timeline">
<?php
             foreach ($tweets['tweets'] as $tweet) {
                    if (is_object($tweet)) {
                        $tweet_text = htmlentities($tweet->text, ENT_QUOTES);
?>
                    <li>
                        <span class="content"><?php echo $tweet_text; ?></span>
                        <div class="date"><?php echo human_time_diff(strtotime($tweet->created_at)); ?> ago </div>
                    </li>
<?php
                    }
            }
?>
            </ul>
<?php
            echo $args['after_widget'];
        }
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
            $title = __('Twitter', $this->textDomain);
        }

        if (isset($instance['consumer_key'])) {
            $consumer_key = $instance['consumer_key'];
        } else {
            $consumer_key = '';
        }

        if (isset($instance['consumer_secret'])) {
            $consumer_secret = $instance['consumer_secret'];
        } else {
            $consumer_secret = '';
        }

        if (isset($instance['access_token'])) {
            $access_token = $instance['access_token'];
        } else {
            $access_token = '';
        }

        if (isset($instance['access_secret'])) {
            $access_secret = $instance['access_secret'];
        } else {
            $access_secret = '';
        }
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('consumer_key'); ?>"><?php _e('Consumer Key:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('consumer_key'); ?>" name="<?php echo $this->get_field_name('consumer_key'); ?>" type="text" value="<?php echo esc_attr($consumer_key); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('consumer_secret'); ?>"><?php _e('Consumer Secret:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('consumer_secret'); ?>" name="<?php echo $this->get_field_name('consumer_secret'); ?>" type="text" value="<?php echo esc_attr($consumer_secret); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('access_token'); ?>"><?php _e('Access Token:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" type="text" value="<?php echo esc_attr($access_token); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('access_secret'); ?>"><?php _e('Access Secret:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('access_secret'); ?>" name="<?php echo $this->get_field_name('access_secret'); ?>" type="text" value="<?php echo esc_attr($access_secret); ?>" />
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
		$instance['consumer_key'] = (!empty($new_instance['consumer_key'])) ? strip_tags($new_instance['consumer_key']) : '';
        $instance['consumer_secret'] = (!empty($new_instance['consumer_secret'])) ? strip_tags($new_instance['consumer_secret']) : '';
        $instance['access_token'] = (!empty($new_instance['access_token'])) ? strip_tags($new_instance['access_token']) : '';
        $instance['access_secret'] = (!empty($new_instance['access_secret'])) ? strip_tags($new_instance['access_secret']) : '';
        return $instance;
    }

    /**
     * Retrieve Tweets from Timeline
     *
     * @param $widget_id
     * @param $instance
     * @return mixed
     */
    function retrieve_tweets($widget_id, $instance) {
        global $cb;
        $timeline = $cb->statuses_userTimeline('screen_name=' . $instance['username']. '&count=' . $instance['limit'] . '&exclude_replies=true');
        return $timeline;
    }

    /**
     * Save tweets to database
     *
     * @param $widget_id
     * @param $instance
     * @return array
     */
    function save_tweets($widget_id, $instance) {
        $timeline = $this->retrieve_tweets($widget_id, $instance );
        $tweets = array('tweets' => $timeline, 'update_time' => time() + (60 * 5));
        update_option('my_tweets_' . $widget_id, $tweets);
        return $tweets;
    }

    /**
     * Get Tweets from Database
     *
     * @param $widget_id
     * @param $instance
     * @return array|mixed|void
     */
    function get_tweets($widget_id, $instance) {
        $tweets = get_option('my_tweets_' . $widget_id);
        if(empty($tweets) OR time() > $tweets['update_time']) {
            $tweets = $this->save_tweets($widget_id, $instance);
        }

        return $tweets;
    }
}

function Yonk_twitter_load_widget() {
    register_widget('Yonk_Twitter');
}

add_action('widgets_init', 'Yonk_twitter_load_widget');