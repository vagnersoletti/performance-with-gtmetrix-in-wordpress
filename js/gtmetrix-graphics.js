jQuery(document).ready(function($) {

    $.ajax({
        url: ajaxurl,
        data: {
            'action': 'create_graphics_gtmetrix'
        },
        success:function(response) {

            am4core.useTheme(am4themes_animated);
            // Themes end

            var chart = am4core.create("chartdiv", am4charts.XYChart);
            chart.paddingRight = 20;

            var data = [];
            var previousValue;

            var i;
            for (i = 0; i < response.length; i++) { 
                data.push({ date: new Date(response[i]['created_at']), value: response[i]['pagespeed'] });
                previousValue = response[i]['pagespeed'];
            }

            chart.data = data;

            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.grid.template.location = 0;
            dateAxis.renderer.axisFills.template.disabled = true;
            dateAxis.renderer.ticks.template.disabled = true;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.renderer.minWidth = 35;
            valueAxis.renderer.axisFills.template.disabled = true;
            valueAxis.renderer.ticks.template.disabled = true;

            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.dateX = "date";
            series.dataFields.valueY = "value";
            series.strokeWidth = 2;
            series.tooltipText = "PageSpeed Score: {valueY}, Valor alterado: {valueY.previousChange}";

            // set stroke property field
            series.propertyFields.stroke = "color";

            chart.cursor = new am4charts.XYCursor();

            var scrollbarX = new am4core.Scrollbar();
            chart.scrollbarX = scrollbarX;

            chart.events.on("ready", function(ev) {
                dateAxis.zoomToDates(
                    chart.data[0].date,
                    chart.data.slice(-1)[0].date
                );
            });


            var chart = am4core.create("chartdiv2", am4charts.XYChart);
            chart.paddingRight = 20;

            var data = [];
            var previousValue;

            var i;
            for (i = 0; i < response.length; i++) { 
                data.push({ date: new Date(response[i]['created_at']), value: response[i]['fullloadedtime'] });
                previousValue = response[i]['fullloadedtime'];
            }

            chart.data = data;

            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.grid.template.location = 0;
            dateAxis.renderer.axisFills.template.disabled = true;
            dateAxis.renderer.ticks.template.disabled = true;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.tooltip.disabled = true;
            valueAxis.renderer.minWidth = 35;
            valueAxis.renderer.axisFills.template.disabled = true;
            valueAxis.renderer.ticks.template.disabled = true;

            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.dateX = "date";
            series.dataFields.valueY = "value";
            series.strokeWidth = 2;
            series.tooltipText = "Fully Loaded Time: {valueY}, Valor alterado: {valueY.previousChange}";

            // set stroke property field
            series.propertyFields.stroke = "color";

            chart.cursor = new am4charts.XYCursor();

            var scrollbarX = new am4core.Scrollbar();
            chart.scrollbarX = scrollbarX;

            chart.events.on("ready", function(ev) {
                dateAxis.zoomToDates(
                    chart.data[0].date,
                    chart.data.slice(-1)[0].date
                );
            });

        },
        error: function(errorThrown){
            $('#gtmetrix-dashboard .loading').hide();
            console.log(errorThrown);
        }

    });  

});