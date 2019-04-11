<?php
/**
 * Creates the pages page for the plugin.
 *
 * @package Performance with GTmetrix in WordPress
 */
 
class pages {

    /**
     * A reference to the class for retrieving our option values.
     * @var Deserializer
     */
    private $deserializer;

    /**
     * Initializes pages
     */
    public function __construct( $deserializer ) {
        $this->deserializer = $deserializer;
    }

    /**
     * Create page dashboard
     */
    public function dashboard() {
        include_once( 'views/dashboard.php' );
    }


    /**
     * Create page logs gtmetrix
     */
    public function logs() {
        include_once( 'views/logs.php' );
    }

    /**
     * Create page register
     */
    public function register() {
        include_once( 'views/register.php' );
    }


    /**
     * Create page logs server
     */
    public function server() {
        include_once( 'views/server.php' );
    }
}