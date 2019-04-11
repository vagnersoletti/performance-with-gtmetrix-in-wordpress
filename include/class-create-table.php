<?php
/**
 * Creates table usaded for the plugin.
 *
 * @package Performance with GTmetrix in WordPress
 */

class Create_Table {

    public function __construct(){
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table_config = $wpdb->prefix . 'gtmetrix';
        $table_log = $wpdb->prefix . 'gtmetrix_log';
        $table_log_server = $wpdb->prefix . 'gtmetrix_log_server';

        $sql = "CREATE TABLE $table_config (
            id int(11) NOT NULL AUTO_INCREMENT,
            title varchar(200) NOT NULL,
            email varchar(150) NOT NULL,
            token varchar(255) NOT NULL,
            cron int(11) NOT NULL,
            sendreport varchar(150) NOT NULL,
            url varchar(255) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        $sql .= "CREATE TABLE $table_log (
            id int(11) NOT NULL AUTO_INCREMENT,
            pagespeed int(11) NOT NULL,
            yslow int(11) NOT NULL,
            fullloadedtime varchar(20) NOT NULL,
            totalpagesize varchar(20) NOT NULL,
            requests int(11) NOT NULL,
            linkreportfull varchar(255) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY id (id)
        ) $charset_collate;";
        
        $sql .= "CREATE TABLE $table_log_server (
            id int(11) NOT NULL AUTO_INCREMENT,
            dstime varchar(20) NOT NULL,
            tcptime varchar(20) NOT NULL,
            filestime varchar(20) NOT NULL,
            bytetime varchar(20) NOT NULL,
            totaltime varchar(20) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        
    }

}