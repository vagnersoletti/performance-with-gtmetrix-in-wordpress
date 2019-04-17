<?php
/**
 * Creates ajax requests
 *
 * @package Performance with GTmetrix in WordPress
 */
 
class Ajax_Requests {

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

        add_action( 'wp_ajax_request_services_gtmetrix', array( $this, 'request_services_gtmetrix' ));
        add_action( 'wp_ajax_nopriv_request_services_gtmetrix', array( $this, 'request_services_gtmetrix' ));

        add_action( 'wp_ajax_create_graphics_gtmetrix', array( $this, 'create_graphics_gtmetrix' ));
        add_action( 'wp_ajax_nopriv_create_graphics_gtmetrix', array( $this, 'create_graphics_gtmetrix' ));
    }

    
    /**
     * Create request
     */
    public function request_services_gtmetrix() {

        include_once WP_PLUGIN_DIR.'/performance-with-gtmetrix-in-wordpress/functions/function.php';

        global $wpdb;

        if ( isset($_REQUEST) ) {

            $test = new Services_WTF_Test($this->deserializer->get_value()->email, $this->deserializer->get_value()->token);
            $url_to_test = $this->deserializer->get_value()->url;

            
            $testid = $test->test(array('url' => $url_to_test));
            
            if (!$testid) {
                die("Test failed: " . $test->error() . "\n"); 
            }

            // $test->status();
            $test->get_results();
            $results = $test->results();

          
            $urlChange = explode('/', $url_to_test);
            $ch = curl_init($urlChange[2]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            $connect_time = curl_getinfo($ch, CURLINFO_CONNECT_TIME);
            $namelookup_time = curl_getinfo($ch, CURLINFO_NAMELOOKUP_TIME);
            $pretransfer_time = curl_getinfo($ch, CURLINFO_PRETRANSFER_TIME);
            $starttranfer_time = curl_getinfo($ch, CURLINFO_STARTTRANSFER_TIME);
            $total_time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);

            $table_name = $wpdb->prefix . "gtmetrix_log_server";
            $wpdb->insert($table_name, array( 'dstime' => $serverLog['namelookup_time'], 
                                              'tcptime' => $serverLog['connect_time'], 
                                              'filestime' => $serverLog['pretransfer_time'], 
                                              'bytetime' => $serverLog['starttransfer_time'], 
                                              'totaltime' => $serverLog['total_time']
                                            )
            );
            

            $table_name = $wpdb->prefix . "gtmetrix_log";
            $wpdb->insert($table_name, array( 'pagespeed' => $results['pagespeed_score'], 
                                              'yslow' => $results['yslow_score'], 
                                              'fullloadedtime' => $results['fully_loaded_time']/1000, 
                                              'totalpagesize' => By2M($results['page_bytes']), 
                                              'requests' => $results['page_elements'], 
                                              'linkreportfull' => $results['report_url'] )
            );

            wp_send_json(
                array (
                    'pagespeed_score'   => $results['pagespeed_score'], 
                    'yslow_score'       => $results['yslow_score'], 
                    'fully_loaded_time' => $results['fully_loaded_time']/1000, 
                    'page_bytes'        => By2M($results['page_bytes']), 
                    'page_elements'     => $results['page_elements'], 
                    'dstime'            => number_format($namelookup_time, 3, '.', ''),
                    'tcptime'           => number_format($connect_time, 3, '.', ''),
                    'filestime'         => number_format($pretransfer_time, 3, '.', ''),
                    'bytetime'          => number_format($starttranfer_time, 3, '.', ''),
                    'totaltime'         => number_format($total_time, 3, '.', ''),
                    'lastTesteDashboad' => date( 'd/m/y', strtotime('now')) .' às '.date( 'g:i A', strtotime('now'))
                )
            );
            
        }
        die();
    }


    /**
     * Create graphics
     */
    public function create_graphics_gtmetrix() {

        global $wpdb;

        $table_name = $wpdb->prefix . "gtmetrix_log";
        $logs = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY created_at ASC", $output = ARRAY_A);

        foreach ($logs as $log) {
            $rows[] = array(
                'created_at' => date( 'Y, m, d', strtotime($log['created_at'])),
                'pagespeed' => $log['pagespeed'], 
                'fullloadedtime' => $log['fullloadedtime']
            );
        }

        wp_send_json($rows);

        die();
    }

}