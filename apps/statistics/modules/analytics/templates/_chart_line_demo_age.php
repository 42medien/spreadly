<?php use_helper('ChartData') ?>
<div id="chart_line_demo_age" class="area-chart left"></div>
<script type="text/javascript">
var ViewRangeChart = {
	init: function(pChartsettings) {
		//var Highcharts = new Highcharts;
    var lData = <?php echo getAgeChartData($pData); ?>;
	  Highcharts.theme = { colors: [] };// prevent errors in default theme
		var lOptions = {
		    chart: {
		      renderTo: 'chart_line_demo_age',
		      zoomType: 'x',
		      spacingRight: pChartsettings.spacingRight,
	        margin: pChartsettings.margin,
	        height: parseInt(pChartsettings.height),
		      width: parseInt(pChartsettings.width),
          backgroundColor: '#fff',
          plotBackgroundColor: '#fff'
		   },
		    title: {
		      text: false
		   },
       exporting: {
         buttons: {
           exportButton: {
             enabled: false
           },
           printButton: {
             enabled: false
           }

         }
       },
		   xAxis: {
		      type: 'linear',
		      maxZoom: 10, // fourteen days
		      title: {
		         text: null
		      }
		   },
		   yAxis: {
		      title: {
		         text: false
		      },
		      min: 0.6,
		      startOnTick: false,
		      showFirstLabel: false
		   },
		   tooltip: {
		      shared: true
		   },
		   legend: {
		      enabled: false
		   },
		   plotOptions: {
		      area: {
		         lineWidth: 1,
		         marker: {
		            enabled: true,
		            states: {
		               hover: {
		                  enabled: true,
		                  radius: 5
		               }
		            }
		         },
		         shadow: false,
		         states: {
		            hover: {
		               lineWidth: 1
		            }
		         }
		      }
		   },

		   series: [{
		      type: 'area',
		      name: 'Age',
		      pointInterval: 1,
		      pointStart: 15,
		      data: lData.age,
		      color: '#1231e3',
	        fillOpacity: 0.1,
	        fillColor: {
            linearGradient: [0, 0, 0, 300],
            stops: [
               [0, Highcharts.theme.colors[0]],
               [1, 'rgba(61,160,242,0)']
            ]
         }

		   }
		   ]
		};

		var highchartsOptions = Highcharts.getOptions();
		new Highcharts.Chart(lOptions);
	}//end init
};//end object
ViewRangeChart.init(<?php echo $pChartsettings; ?>);
</script>