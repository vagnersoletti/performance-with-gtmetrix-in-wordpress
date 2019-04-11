<?php
/**
 * Creates the menu item for the plugin.
 *
 * @package Performance with GTmetrix in WordPress
 */
 
class Logs {
 
    /**
     * Initializes all of the partial classes.
     */
    public function __construct(  ) {
    }
 
    public function logGTmetrix($text) {
        $dir = "log/";
        $filename = "log.log";

        if ( file_exists($dir.$filename) ) {
            $nb = 1;
            $logfiles = scandir($dir);
            foreach ($logfiles as $file) {
                $tmpnb = substr($file, strlen($filename));
                if($nb < $tmpnb){
                    $nb = $tmpnb;
                }
            }
        }
        $data = date('Y-m-d H:i:s')." - ".$text.PHP_EOL;
        file_put_contents(WP_CONTENT_DIR . '/plugins/gtmetrix/'.$dir.$filename, $data, FILE_APPEND);

    }


    public function logErrorGTmetrix($text) {
        $dir = "log/";
        $filename = "error.log";

        if ( file_exists($dir.$filename) ) {
            $nb = 1;
            $logfiles = scandir($dir);
            foreach ($logfiles as $file) {
                $tmpnb = substr($file, strlen($filename));
                if($nb < $tmpnb){
                    $nb = $tmpnb;
                }
            }
        }
        $data = date('Y-m-d H:i:s')." - ERROR - ".$text.PHP_EOL;
        file_put_contents(WP_CONTENT_DIR . '/plugins/gtmetrix/'.$dir.$filename, $data, FILE_APPEND);

    }

}