<?php
include_once WP_PLUGIN_DIR.'/performance-with-gtmetrix-in-wordpress/functions/function.php';
?>


<div class="wrap gtmetrix-wrap">
    <div class="gtmetrix-header gtmetrix-page-header">
        <h1 class="gtmetrix-header-title">Dashboard</h1>
        <div class="gtmetrix-actions-right">
            <a href="https://gtmetrix.com/pro/" target="_blank" class="gtmetrix button-secondary">Informações sobre créditos</a>
            <button class="gtmetrix-button" id="test-performance">
                <img src="<?php echo plugins_url('/performance-with-gtmetrix-in-wordpress/img/play.svg'); ?>" width="16"> Realizar teste
            </button>
        </div>
    </div>
    <div class="gtmetrix-box">
    <?php 
    
        $showCreatedAt = date( 'd/m/y', strtotime($this->deserializer->get_last_log()->created_at)) .' às '.date( 'g:i A', strtotime($this->deserializer->get_last_log()->created_at)); 
    
    ?>
        <h4>Último teste realizado em: <span class="lastTesteDashboad"><?php echo $showCreatedAt; ?></span></h4>
        <div id="gtmetrix-dashboard">
            <div class="loading">Carregando.. aguarde!</div>
            <div class="report-scores"> 
                <h3>Performance Scores</h3>
                <div class="box clear">
                    <div class="report-score">
                        <h5>PageSpeed Score</h5>
                        <span class="report-score-grade color-grade-<?php echo score_to_grade($this->deserializer->get_last_log()->pagespeed); ?>"><i class="sprite-grade-<?php echo score_to_grade($this->deserializer->get_last_log()->pagespeed); ?>"></i>
                            <?php echo score_to_grade($this->deserializer->get_last_log()->pagespeed); ?><span class="report-score-percent">(<span class="pagespeed_score"><?php echo $this->deserializer->get_last_log()->pagespeed; ?></span>%)</span>
                        </span>
                        <i class="site-average sprite-average-below hover-tooltip tooltipstered" data-tooltip-interactive=""></i>
                    </div>
                    <div class="report-score">
                        <h5>YSlow Score</h5>
                        <span class="report-score-grade color-grade-<?php echo score_to_grade($this->deserializer->get_last_log()->yslow); ?>"><i class="sprite-grade-<?php echo score_to_grade($this->deserializer->get_last_log()->yslow); ?>"></i>
                        <?php echo score_to_grade($this->deserializer->get_last_log()->yslow); ?><span class="report-score-percent">(<span class="yslow_score"><?php echo $this->deserializer->get_last_log()->yslow; ?></span>%)</span>
                        </span>
                        <i class="site-average sprite-average-below hover-tooltip tooltipstered" data-tooltip-interactive=""></i>
                    </div>
                </div>
            </div>

            <div class="report-page-details">
                <h3>Page Details</h3>
                <div class="box clear">
                    <div class="report-page-detail">
                        <h5>Fully Loaded Time (s)</h5>
                        <span class="report-page-detail-value"><span class="fully_loaded_time"><?php echo $this->deserializer->get_last_log()->fullloadedtime; ?></span></span>
                        <i class="site-average sprite-average-below hover-tooltip tooltipstered" data-tooltip-interactive=""></i>
                    </div>
                    <div class="report-page-detail report-page-detail-size">
                        <h5>Total Page Size (MB)</h5>
                        <span class="report-page-detail-value"><span class="page_bytes"><?php echo $this->deserializer->get_last_log()->totalpagesize; ?></span></span>
                        <i class="site-average sprite-average-above hover-tooltip tooltipstered" data-tooltip-interactive=""></i>
                    </div>
                    <div class="report-page-detail report-page-detail-requests">
                        <h5>Requests</h5>
                        <span class="report-page-detail-value"><span class="page_elements"><?php echo $this->deserializer->get_last_log()->requests; ?></span></span>
                        <i class="site-average sprite-average-below hover-tooltip tooltipstered" data-tooltip-interactive=""></i>
                    </div>
                </div>
            </div>
        </div>
        <div id="gtmetrix-view-report">
            <a href="<?php echo $this->deserializer->get_last_log()->linkreportfull; ?>" target="_blank">Relatório completo</a>
        </div>
        <br /><br />
        <div id="gtmetrix-dashboard">
            <div class="report-servers"> 
                <h3>Performance Servidor</h3>
                <div class="box clear">
                    <div class="report-server">
                        <h5>DS Time</h5>
                        <span class="report-score-grade color-grade"><i class="sprite-grade"></i>
                            <span class="report-score-percent">(<span class="dstime"><?php echo $this->deserializer->get_last_log_server()->dstime; ?></span>s)</span>
                        </span>
                        <i class="site-average sprite-average-below hover-tooltip tooltipstered" data-tooltip-interactive=""></i>
                    </div>
                    <div class="report-server">
                        <h5>TCP Time</h5>
                        <span class="report-score-grade color-grade"><i class="sprite-grade"></i>
                            <span class="report-score-percent">(<span class="tcptime"><?php echo $this->deserializer->get_last_log_server()->tcptime; ?></span>s)</span>
                        </span>
                        <i class="site-average sprite-average-below hover-tooltip tooltipstered" data-tooltip-interactive=""></i>
                    </div>
                    <div class="report-server">
                        <h5>Files Time</h5>
                        <span class="report-score-grade color-grade"><i class="sprite-grade"></i>
                            <span class="report-score-percent">(<span class="filestime"><?php echo $this->deserializer->get_last_log_server()->filestime; ?></span>s)</span>
                        </span>
                        <i class="site-average sprite-average-below hover-tooltip tooltipstered" data-tooltip-interactive=""></i>
                    </div>
                    <div class="report-server">
                        <h5>Byte Time</h5>
                        <span class="report-score-grade color-grade"><i class="sprite-grade"></i>
                            <span class="report-score-percent">(<span class="bytetime"><?php echo $this->deserializer->get_last_log_server()->bytetime; ?></span>s)</span>
                        </span>
                        <i class="site-average sprite-average-below hover-tooltip tooltipstered" data-tooltip-interactive=""></i>
                    </div>
                    <div class="report-server">
                        <h5>Total Time</h5>
                        <span class="report-score-grade color-grade"><i class="sprite-grade"></i>
                            <span class="report-score-percent">(<span class="totaltime"><?php echo $this->deserializer->get_last_log_server()->totaltime; ?></span>s)</span>
                        </span>
                        <i class="site-average sprite-average-below hover-tooltip tooltipstered" data-tooltip-interactive=""></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="gtmetrix-box graphics">
        <div class="width-50">
            <h4>Gráfico de acompanhamento de performance - PageSpeed Score</h4>
            <div id="chartdiv" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
    <div class="gtmetrix-box graphics">
        <div class="width-50">
            <h4>Gráfico de tempo de carregamento - Full Load Time</h4>
            <div id="chartdiv2" style="width: 100%; height: 400px;"></div>
        </div>
    </div>

   
 
</div><!-- .wrap -->