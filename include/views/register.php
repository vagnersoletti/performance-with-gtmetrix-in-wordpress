<div class="wrap">
 
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <br />
 
    <form method="post" action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>">
 
        <div id="gtmetrix-message-container">
            <h2>Conectando ao GTmetrix</h2>
            <p>Informe os dados abaixo para conectado a sua conta no GTmetrix</p>
  
            <div class="options">
                <p>
                    <label><?php _e("Informe seu e-mail"); ?></label>
                    <input type="text" name="gtmetrix-email" value="<?php echo esc_attr( $this->deserializer->get_value()->email ); ?>" />
                </p>
                <p>
                    <label><?php _e("Informe seu token"); ?></label>
                    <input type="text" name="gtmetrix-token" value="<?php echo esc_attr( $this->deserializer->get_value()->token ); ?>" />
                    <em>Para buscar seu token acesse sua <a href="https://gtmetrix.com/" target="_blank">conta no GTmetrix</a></em>
                </p>
                <p>
                    <label><?php _e("Informe o e-mail para enviar relatório diário"); ?></label>
                    <input type="text" name="gtmetrix-sendreport" value="<?php echo esc_attr( $this->deserializer->get_value()->sendreport ); ?>" />
                    <em>Informe o e-mail que gostaria de receber o relatório diário com os dados coletados.</em><br />
                    <em>Separe os e-mails com ","</em><br />
                    <em>Ex.: teste@teste.com.br,teste1@teste.com.br</em>
                </p>
            </div>

        </div>
        
        <?php
            wp_nonce_field( 'gtmetrix-settings-save', 'gtmetrix-message' );
            submit_button();
        ?>
    </form>
</div>