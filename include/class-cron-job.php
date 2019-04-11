<?php
/**
 * Creates the menu item for the plugin.
 *
 * @package Performance with GTmetrix in WordPress
 */
 
class Cron_Jobs {

    /**
     * A reference to the class for retrieving our option values.
     * @var Deserializer
     */
    private $deserializer;
    private $ajax;


    /**
     * Add actions to cron job
     */
    public function __construct( $deserializer, $ajax ) {
        $this->deserializer = $deserializer;
        $this->ajax = $ajax;

        // run cron-job performance 
        add_filter( 'wp', array( $this, 'cronstarter_activation' ));
        register_deactivation_hook( __FILE__  , array( $this, 'cronstarter_deactivate' ));
        add_action('cron_performance', array( $this, 'send_performance' ));

        // run send mail report performance 
        add_filter( 'wp', array( $this, 'send_mail_performance_activation'));
        add_action('cron_mail_performance', array( $this, 'send_mail_performance'));

    }

    function send_mail_performance_activation() {
        if ( !wp_next_scheduled( 'cron_mail_performance' )) {
            wp_schedule_event( strtotime('07:00:00'), 'daily', 'cron_mail_performance' );
            // wp_schedule_event( time() + 2000, 'daily', 'cron_mail_performance' );
        }
    }

    function cronstarter_activation() {
        if( !wp_next_scheduled( 'cron_performance' ) ) {
            wp_schedule_event( strtotime('06:00:00'), 'daily', 'cron_performance' );
            // wp_schedule_event( time() + 1500, 'daily', 'cron_performance' );
        }
    }

    function send_mail_performance() {
        $message = '
        
        <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Brognoli - Performance</title>
            </head>
            <body>
                <center>
                    <h2>Brognoli - Relatório diário de performance</h2>
                </center>
                <center>
                    <table style="width: 500px; font-size: 20px;text-align: left;">
                        <tr>
                            <th style="padding: 20px 0 3px;">Performance Scores</th>
                            <td></td>
                        </tr>
                        <tr>
                            <td>PageSpeed Score (%)</td>
                            <td>'.$this->deserializer->get_last_log()->pagespeed.'</td>
                        </tr>
                        <tr>
                            <td>YSlow Score (%)</td>
                            <td>'.$this->deserializer->get_last_log()->yslow.'</td>
                        </tr>
                        <tr>
                            <th style="padding: 20px 0 3px;">Page Details</th>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Fully Loaded Time (s)</td>
                            <td>'.$this->deserializer->get_last_log()->fullloadedtime.'</td>
                        </tr>
                        <tr>
                            <td>Total Page Size (MB)</td>
                            <td>'.$this->deserializer->get_last_log()->totalpagesize.'</td>
                        </tr>
                        <tr>
                            <td>Requests</td>
                            <td>'.$this->deserializer->get_last_log()->requests.'</td>
                        </tr>
                        <tr>
                            <th style="padding: 20px 0 3px;">Performance do servidor</th>
                            <td></td>
                        </tr>
                        <tr>
                            <td>DS Time (s)</td>
                            <td>'.$this->deserializer->get_last_log_server()->dstime.'</td>
                        </tr>
                        <tr>
                            <td>TCP Time (s)</td>
                            <td>'.$this->deserializer->get_last_log_server()->tcptime.'</td>
                        </tr>
                        <tr>
                            <td>Files Time (s)</td>
                            <td>'.$this->deserializer->get_last_log_server()->filestime.'</td>
                        </tr>
                        <tr>
                            <td>Byte Time (s)</td>
                            <td>'.$this->deserializer->get_last_log_server()->bytetime.'</td>
                        </tr>
                        <tr>
                            <td>Total Time (s)</td>
                            <td>'.$this->deserializer->get_last_log_server()->totaltime.'</td>
                        </tr>
                    </table>
                    <div>Enviado por: </div>'.get_site_url().'
                </center>
            </body>
        </html>
        
        ';

        // global $phpmailer;

        // if ( ! ( $phpmailer instanceof PHPMailer ) ) {
        //     require_once ABSPATH . WPINC . '/class-phpmailer.php';
        //     require_once ABSPATH . WPINC . '/class-smtp.php';
        // }
        
        // $phpmailer = new PHPMailer();

        // DEFINIÇÃO DOS DADOS DE AUTENTICAÇÃO - Você deve auterar conforme o seu domínio!
        // $phpmailer->IsSMTP(); // Define que a mensagem será SMTP
        // $phpmailer->Host = "mail.brognoli.com.br"; // Seu endereço de host SMTP
        // $phpmailer->SMTPAuth = true; // Define que será utilizada a autenticação -  Mantenha o valor "true"
        // $phpmailer->Port = 587; // Porta de comunicação SMTP - Mantenha o valor "587"
        // $phpmailer->SMTPSecure = false; // Define se é utilizado SSL/TLS - Mantenha o valor "false"
        // $phpmailer->SMTPAutoTLS = false; // Define se, por padrão, será utilizado TLS - Mantenha o valor "false"
        // $phpmailer->Username = 'naoresponda@brognoli.com.br'; // Conta de email existente e ativa em seu domínio
        // $phpmailer->Password = 'Brog2020'; // Senha da sua conta de email
        
        // DADOS DO REMETENTE
        // $phpmailer->Sender = "naoresponda@brognoli.com.br"; // Conta de email existente e ativa em seu domínio
        // $phpmailer->From = "naoresponda@brognoli.com.br"; // Sua conta de email que será remetente da mensagem
        // $phpmailer->FromName = "Brognoli Negocios Imobiliarios"; // Nome da conta de email
        
        // DADOS DO DESTINATÁRIO
        // $emails = explode(",", $this->deserializer->get_value()->sendreport);
        // foreach ($emails as $email) {
        //     $phpmailer->AddAddress("$email");
        // }

        $to = $this->deserializer->get_value()->sendreport;
        $subject = "Brognoli - Relatório diário de performance";
        $headers = 'From: '. get_option( 'admin_email' ) . "\r\n" .
            'Reply-To: ' . get_option( 'admin_email' ) . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        
        $sent = wp_mail($to, $subject, $message, $headers);

        if( $sent ) {
            $this->log->logGTmetrix('E-mail enviado com sucesso!');
        } else  {
            $this->log->logErrorGTmetrix('Não foi possível enviar o e-mail.');
            $this->log->logErrorGTmetrix('Detalhes do erro:'.$phpmailer->ErrorInfo);
        }
        
        // Definição de HTML/codificação
        // $phpmailer->IsHTML(true); // Define que o e-mail será enviado como HTML
        // $phpmailer->CharSet = 'utf-8'; // Charset da mensagem (opcional)
        
        // // DEFINIÇÃO DA MENSAGEM
        // $phpmailer->Subject  = "Brognoli - Relatório diário de performance"; // Assunto da mensagem
        // $phpmailer->Body = $message;
        // // $phpmailer->Body = 'TESTE DE MENSAGEM';
        
        // // ENVIO DO EMAIL
        // $enviado = $phpmailer->Send();
        // // Limpa os destinatários e os anexos
        // $phpmailer->ClearAllRecipients();
        
        // // Exibe uma mensagem de resultado do envio (sucesso/erro)
        // if ($enviado) {
        //     $this->log->logGTmetrix('E-mail enviado com sucesso!');
        // } else {
        //     $this->log->logErrorGTmetrix('Não foi possível enviar o e-mail.');
        //     $this->log->logErrorGTmetrix('Detalhes do erro:'.$phpmailer->ErrorInfo);
        // }
    }

    function cronstarter_deactivate() {
        $timestamp = wp_next_scheduled( 'cron_performance' );
        wp_unschedule_event( $timestamp, 'cron_performance' );
    }

    function send_performance() {
        $this->ajax->request_services_gtmetrix();
    }

}