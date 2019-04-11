<?php
/**
 * Performs all sanitization functions required to save the option values to
 * the database.
 *
 * @package Performance with GTmetrix in WordPress
 */

class Serializer {
    
    /**
     * Initializes save
     */
    public function __construct(){
        add_action( 'admin_post', array( $this, 'save' ) );
    }

    /**
     * Validates the incoming nonce value, verifies the current user has
     * permission to save the value from the options page and saves the
     * option to the database.
     */
    public function save() {
 
        // First, validate the nonce and verify the user as permission to save.
        if ( ! ( $this->has_valid_nonce() && current_user_can( 'manage_options' ) ) ) {
            // TODO: Display an error message.
        }
 
        // If the above are valid, sanitize and save the option.
        if ( null !== wp_unslash( $_POST ) ) {

            global $wpdb;

            $table_name = $wpdb->prefix . "gtmetrix";

            $title  = 'GTmetrix - ' .get_bloginfo( 'name' ); 
            $email  = $_POST['gtmetrix-email'];
            $token  = $_POST['gtmetrix-token']; 
            $sendreport  = $_POST['gtmetrix-sendreport']; 
            $url    = site_url(); 

            $rowcount = $wpdb->get_results("SELECT * FROM " . $table_name . " WHERE email = '".$email."'", $output = ARRAY_A);

            if (!empty($rowcount[0])) {
                $wpdb->update($table_name, array( 'email' => $email, 'token' => $token, 'sendreport' => $sendreport), array("id" => $rowcount[0]['id']) );
            } else {
                $wpdb->insert($table_name, array( 'title' => $title, 'email' => $email, 'token' => $token, 'url' => $url, 'sendreport' => $sendreport), array('%s', '%s') );
            }

        }
        $admin_notice = "success";
        $this->redirect($admin_notice);
    }
 
    /**
     * Determines if the nonce variable associated with the options page is set
     * and is valid.
     *
     * @return boolean False if the field isn't set or the nonce value is invalid;
     *  otherwise, true.
     */
    private function has_valid_nonce() {
 
        // If the field isn't even in the $_POST, then it's invalid.
        if ( ! isset( $_POST['gtmetrix-message'] ) ) {
            return false;
        }
 
        $field  = wp_unslash( $_POST['gtmetrix-message'] );
        $action = 'gtmetrix-settings-save';
 
        return wp_verify_nonce( $field, $action );
 
    }
 
    /**
     * Redirect to the page from which we came (which should always be the
     * admin page. If the referred isn't set, then we redirect the user to
     * the login page.
     */
    private function redirect($admin_notice) {
 
        // To make the Coding Standards happy, we have to initialize this.
        if ( ! isset( $_POST['_wp_http_referer'] ) ) { // Input var okay.
            $_POST['_wp_http_referer'] = wp_login_url();
        }
 
        // Sanitize the value of the $_POST collection for the Coding Standards.
        $url = sanitize_text_field( wp_unslash( $_POST['_wp_http_referer'] ) );

        wp_redirect( esc_url_raw( add_query_arg( array ('gtmetrix_admin_add_notice' => $admin_notice), urldecode( $url ) ) ) );
        exit;
 
    }

    /**
	 * Print Admin Notices
	 */
	public function gtmetrix_admin_notices() {              
        if ( isset( $_REQUEST['gtmetrix_admin_add_notice'] ) ) {
            if( $_REQUEST['gtmetrix_admin_add_notice'] === "success") {
                $html =	'<div class="notice notice-success is-dismissible"><p><strong>Dados atualizados com sucesso.</strong></p></div>';
            }
            echo $html;
        } else {
            return false;
        }

    }
}