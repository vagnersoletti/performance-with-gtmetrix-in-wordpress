<?php
/**
 * The plugin bootstrap file
 *
 *
 * @link              #
 * @since             1.0.0
 * @package           Performance with GTmetrix in WordPress
 *
 * @wordpress-plugin
 * Plugin Name:       Performance with GTmetrix in WordPress
 * Plugin URI:        #
 * Description:       Performance with GTmetrix in WordPress
 * Version:           1.0.0
 * Author:            Vagner Soletti | Vitor Cardoso
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

foreach ( glob( plugin_dir_path( __FILE__ ) . 'include/*.php' ) as $file ) {
    include_once $file;
}

add_action( 'plugins_loaded', 'gtmetrix_custom_admin_settings' );
function gtmetrix_custom_admin_settings() {

    $table = new Create_Table();
    $serializer = new Serializer();
    $serializer->gtmetrix_admin_notices();
    $deserializer = new Deserializer();
    $plugin = new menu( new pages( $deserializer ), $deserializer );
    $ajax = new Ajax_Requests( $deserializer );
    $log = new Logs();
    $cron = new Cron_Jobs( $deserializer, $ajax, $log);
}

function gtmetrix_style() {
    wp_enqueue_style('gtmetrix-css', PLUGINS_URL('css/gtmetrix.css', __FILE__));
    wp_enqueue_style('gtmetrix-roboto-css', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900');

    //graphics
    wp_enqueue_script( 'gtmetrix-graphics-js-chart-core', 'https://www.amcharts.com/lib/4/core.js');
    wp_enqueue_script( 'gtmetrix-graphics-js-chart-charts', 'https://www.amcharts.com/lib/4/charts.js');
    wp_enqueue_script( 'gtmetrix-graphics-js-chart-animated', 'https://www.amcharts.com/lib/4/themes/animated.js');

    //ajax
    wp_enqueue_script('gtmetrix-ajax-script', plugin_dir_url( __FILE__ ) . '/js/gtmetrix-services.js', array('jquery'));
    wp_enqueue_script('gtmetrix-ajax-graphics', plugin_dir_url( __FILE__ ) . '/js/gtmetrix-graphics.js', array('jquery'));
	wp_localize_script('gtmetrix-ajax-script', 'gtmetrix_ajax_obj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('admin_enqueue_scripts', 'gtmetrix_style');


