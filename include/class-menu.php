<?php
/**
 * Creates the menu item for the plugin.
 *
 * @package Performance with GTmetrix in WordPress
 */
 
class menu {
 
    /**
     * @var $pages
     */
    private $pages;

    /**
     * A reference to the class for retrieving our option values.
     * @var Deserializer
     */
    private $deserializer;
 
    /**
     * Initializes all of the partial classes.
     */
    public function __construct( $pages, $deserializer ) {
        $this->deserializer = $deserializer;

        $this->pages = $pages;
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    }
 
    /**
     * Creates the menu item and calls on the menu page object to render
     * the actual contents of the page.
     */
    public function add_options_page() {

        if (!empty($this->deserializer->get_value()->email)) {

            add_menu_page(
                'GTmetrix', 
                'GTmetrix',
                'manage_options', 
                'gtmetrix-dashboard', 
                array( $this->pages, 'dashboard' ),
                plugins_url('/performance-with-gtmetrix-in-wp/img/dashboard.png')
            );

            add_submenu_page(
                'gtmetrix-dashboard',
                'Dados GTmetrix',
                'Dados GTmetrix',
                'manage_options', 
                'gtmetrix-config', 
                array( $this->pages, 'logs' )
            );
    
            add_submenu_page(
                'gtmetrix-dashboard',
                'Dados Servidor',
                'Dados Servidor',
                'manage_options', 
                'gtmetrix-server', 
                array( $this->pages, 'server' )
            );

            add_submenu_page(
                'gtmetrix-dashboard',
                'Conectar',
                'Conectar',
                'manage_options', 
                'gtmetrix-register', 
                array( $this->pages, 'register' )
            );

        } else {

            add_menu_page(
                'GTmetrix', 
                'GTmetrix',
                'manage_options', 
                'gtmetrix-register', 
                array( $this->pages, 'register' ) ,
                plugins_url('/performance-with-gtmetrix-in-wp/img/dashboard.png')
            );

        }

        
 
        
    }
}