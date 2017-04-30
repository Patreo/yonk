<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Yonk_Template engine
 *
 * Implements the same interface as Savant3 and Smarty, but is more
 * lightweight.
 *
 * It is originally created in this Sitepoint article:
 * http://www.sitepoint.com/article/beyond-template-engine
 *
 * @link http://www.pfernandes.pt
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 *
 * Usage
 * <code>
 *   $tpl = new Template('/path/to/templates');
 *   $tpl->set('variable', 'some value');
 *   $tpl->display('template-tpl.php');
 * </code>
 */
class Yonk_Template
{
    var $vars; // Holds all the template variables
    var $path; // Path to the templates

    /**
     * Constructor of Template
     *
     * @param string $path the path to the templates
     * @return void
     */
    function __construct($path = null) {
        $this->path = $path;
        $this->vars = array();
    }

    /**
     * Set the path to the template files.
     *
     * @param string $path path to template files
     * @return void
     */
    function setPath($path) {
        $this->path = $path;
    }

    /**
     * Set a template variable.
     *
     * @param string $name name of the variable to set
     * @param mixed $value the value of the variable
     * @return void
     */
    function assign($name, $value) {
        $this->vars[$name] = $value;
    }

    /**
     * Set a bunch of variables at once using an associative array.
     *
     * @param array $vars array of vars to set
     * @param bool $clear whether to completely overwrite the existing vars
     * @return void
     */
    function setVars($vars, $clear = false) {
        if ($clear) {
            $this->vars = $vars;
        } else {
            if (is_array($vars)) {
                $this->vars = array_merge($this->vars, $vars);
            }
        }
    }

    /**
     * Open, parse, and return the template file.
     *
     * @param string $file the template file name
     * @return string
     */
    function fetch($file) {
        extract($this->vars); // Extract the vars to local namespace
        ob_start(); // Start output buffering
        include $this->path . $file; // Include the file
        $contents = ob_get_contents(); // Get the contents of the buffer
        ob_end_clean(); // End buffering and discard
        return $contents; // Return the contents
    }

    /**
     * Displays the template directly
     *
     * @param string $file the template file name
     * @return string
     */
    function display($file) {
        echo $this->fetch($file);
    }

}

