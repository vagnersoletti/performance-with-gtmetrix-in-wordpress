<?php
/**
 * Retrieves information from the database.
 *
 * @package Performance with GTmetrix in WordPress
 */
class Deserializer {
 
    /**
     * Retrieves the value for the option identified by the specified key. If
     * the option value doesn't exist, then an empty string will be returned.
     */
    public function get_value() {
        global $wpdb;
        $table_name = $wpdb->prefix . "gtmetrix";
        $return = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC LIMIT 1" );
        return $return[0];
    }

    public function get_last_log() {
        global $wpdb;
        $table_name = $wpdb->prefix . "gtmetrix_log";
        $return = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC LIMIT 1" );
        return $return[0];
    }
    
    public function get_last_log_server() {
        global $wpdb;
        $table_name = $wpdb->prefix . "gtmetrix_log_server";
        $return = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC LIMIT 1" );
        return $return[0];
    }

}