<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class Yonk_Model
 *
 * @since 1.0
 * @version 1.0
 * @author Pedro Fernandes
 * @link http://www.pfernandes.pt
 */
class Yonk_Model
{
    private $connection;

    /**
     * Constructor of Model
     */
    public function __construct() {
        global $wpdb;
        $this->connection = $wpdb;
    }
    /**
     * Query data from $wpdb connection
     *
     * @param $qry
     * @return mixed
     */
    public function query($qry) {
        return $this->connection->get_results($qry, ARRAY_A);
    }

}