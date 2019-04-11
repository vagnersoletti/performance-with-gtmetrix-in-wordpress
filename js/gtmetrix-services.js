jQuery(document).ready(function($) {

    $( "#test-performance" ).on( "click", function() {
        $.ajax({
            url: ajaxurl,
            data: {
                'action': 'request_services_gtmetrix'
            },
            beforeSend: function(){
                $('#gtmetrix-dashboard .loading').show();
                $("#test-performance").prop("disabled",true);
                $('#gtmetrix-dashboard .fully_loaded_time').html('');
                $('#gtmetrix-dashboard .page_bytes').html('');
                $('#gtmetrix-dashboard .page_elements').html('');
                $('#gtmetrix-dashboard .pagespeed_score').html('');
                $('#gtmetrix-dashboard .yslow_score').html('');

                $('#gtmetrix-dashboard .dstime').html('');
                $('#gtmetrix-dashboard .tcptime').html('');
                $('#gtmetrix-dashboard .filestime').html('');
                $('#gtmetrix-dashboard .bytetime').html('');
                $('#gtmetrix-dashboard .totaltime').html('');


                $('.wrap.gtmetrix-wrap .lastTesteDashboad').html('');

                $('#gtmetrix-dashboard #gtmetrix-view-report a').attr('href', '');
            },
            success:function(data) {
                $('#gtmetrix-dashboard .loading').hide();
                $("#test-performance").prop("disabled",false);
                $('#gtmetrix-dashboard .fully_loaded_time').html(data['fully_loaded_time']);
                $('#gtmetrix-dashboard .page_bytes').html(data['page_bytes']);
                $('#gtmetrix-dashboard .page_elements').html(data['page_elements']);
                $('#gtmetrix-dashboard .pagespeed_score').html(data['pagespeed_score']);
                $('#gtmetrix-dashboard .yslow_score').html(data['yslow_score']);

                $('#gtmetrix-dashboard .dstime').html(data['dstime']);
                $('#gtmetrix-dashboard .tcptime').html(data['tcptime']);
                $('#gtmetrix-dashboard .filestime').html(data['filestime']);
                $('#gtmetrix-dashboard .bytetime').html(data['bytetime']);
                $('#gtmetrix-dashboard .totaltime').html(data['totaltime']);


                $('.wrap.gtmetrix-wrap .lastTesteDashboad').html(data['lastTesteDashboad']);

                $('#gtmetrix-dashboard #gtmetrix-view-report a').attr('href', data['report_url']);
                console.log(data);
            },
            error: function(errorThrown){
                $('#gtmetrix-dashboard .loading').hide();
                console.log(errorThrown);
            }

        });  
              
    });

});