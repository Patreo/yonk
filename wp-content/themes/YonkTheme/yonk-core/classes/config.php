<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Config
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Config
{
    // Add your server hostname to the appropriate arrays. ($_SERVER['HTTP_HOST'])
    private $productionServers = array('/^your-domain\.com/');
    private $stagingServers = array();
    private $localServers = array('/^localhost/');

    // Leave $me alone. Singleton object.
    private static $me;

    // Db on error, send by email
    public $dbOnError;
    public $dbEmailOnError = false;

    // Set authentication for cookie
    public $authDomain = "";
    public $authSalt;

    // Set email properties
    public $emailTo;

    /**
     * Constructor
     *
     */
    private function __construct() {
        $this->everywhere();
        $i_am_here = $this->whereAmI();

        if ($i_am_here == 'production') {
            $this->production();
            return;
        }
        if ($i_am_here == 'staging') {
            $this->staging();
            return;
        }
        if ($i_am_here == 'local') {
            $this->local();
            return;
        }

        die('<h1>Where am I?</h1> <p>You need to setup your server names in <code>wp-config.php</code></p>
            <p><code>$_SERVER[\'HTTP_HOST\']</code> reported <code>' . $_SERVER['HTTP_HOST'] . '</code></p>');
    }

    /**
     * Allow access to configuration settings statically.
     *
     * @param mixed $key
     * @tutorial
     *    Config::get('some_value')
     */
    public static function get($key) {
        return self::$me->$key;
    }

    /**
     * Get singleton object instance
     *
     */
    public static function getInstance() {
        if (is_null(self::$me)) {
            self::$me = new Yonk_Config();
        }
        return self::$me;
    }

    /**
     * Create default authentication
     *
     */
    private function everywhere() {
        // Settings for the Authentication class
        $this->authDomain = $_SERVER['HTTP_HOST'];
        $this->authSalt = '';
    }

    /**
     * Get production default settings
     *
     */
    private function production() {
        ini_set('display_errors', 0);
        ini_set('error_reporting', E_ALL);

        $this->dbOnError = "die";
        $this->dbEmailOnError = false;
    }

    /**
     * Get Staging default settings
     *
     */
    private function staging() {
        ini_set('display_errors', 1);
        ini_set('error_reporting', E_ALL);

        $this->dbOnError = "die";
        $this->dbEmailOnError = false;
    }

    /**
     * Get local default settings
     *
     */
    private function local() {
        ini_set('display_errors', 1);
        ini_set('error_reporting', E_ALL);

        $this->dbOnError = "die";
        $this->dbEmailOnError = false;
    }

    /**
     * Get where i am located
     *
     */
    public function whereAmI() {
        for ($i = 0; $i < count($this->productionServers); $i++) {
            if (preg_match($this->productionServers[$i], getenv('HTTP_HOST')) === 1) {
                return 'production';
            }
        }

        for ($i = 0; $i < count($this->stagingServers); $i++) {
            if (preg_match($this->stagingServers[$i], getenv('HTTP_HOST')) === 1) {
                return 'staging';
            }
        }

        for ($i = 0; $i < count($this->localServers); $i++) {
            if (preg_match($this->localServers[$i], getenv('HTTP_HOST')) === 1) {
                return 'local';
            }
        }

        return NULL;
    }

    /**
     * Notify user
     *
     * @param mixed $emailSubject
     * @param mixed $msg
     */
    public static function notify($emailSubject, $msg) {
        global $config;
        $email = $config['admin_email'];

        if (Yonk_Config::getInstance()->dbEmailOnError == true) {
            $globals = print_r($GLOBALS, true);

            ob_start();
            debug_print_backtrace();
            $trace = ob_get_contents();
            ob_end_clean();

            $msg .= $trace . "\n\n";
            $msg .= $globals;

            mail($email, $emailSubject, $msg);
        }

        switch (Yonk_Config::getInstance()->dbOnError) {
            case "die":
                $html = '<pre>';
                $html .= '  <strong>' . $msg . '</strong>';
                $html .= '  <br />';
                $html .= debug_print_backtrace();
                $html .= '</pre>';
                wp_die($html);
                break;

            case "redirect":
                Yonk_Controller::redirect($config['error_controller']);
                break;

        	default:
                break;
        }
    }

}