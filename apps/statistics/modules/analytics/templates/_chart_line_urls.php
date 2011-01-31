<?php use_helper('ChartData') ?>
<div id="chart_line_urls" class="area-chart"></div>
<script type="text/javascript">
var ActivityChart = {
	init: function() {
	  Highcharts.theme = { colors: [] };// prevent errors in default theme
	  var lData = <?php echo getChartLineActivitiesData($pData, $pCommunity); ?>;
		var lOptions = {
		    chart: {
		      renderTo: 'chart_line_urls',
		      zoomType: 'x',
		      spacingRight: 20
		   },
		    title: {
		      text: false
		   },
		    subtitle: {
		      text: document.ontouchstart === undefined ?
			         "<?php echo __('Click and drag in the plot area to zoom in'); ?>" :
				       "<?php echo __('Drag your finger over the plot to zoom in'); ?>"
		   },
		   xAxis: {
		      type: 'datetime',
		      maxZoom: 7 * 24 * 3600000, // fourteen days
		      title: {
		         text: null
		      }
		   },
		   yAxis: {
		      title: {
		         text: false
		      },
		      min: 0,
		      maxZoom: 10, // fourteen days
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
		      name: 'Likes',
		      pointInterval: 1*24*60*60*1000,
		      pointStart: Date.UTC(2006, 5, 01),
		      data: lData.likes,
		      color: '#1231e3',
	        fillOpacity: 0.1,
	        fillColor: {
            linearGradient: [0, 0, 0, 300],
            stops: [
               [0, Highcharts.theme.colors[0]],
               [1, 'rgba(61,160,242,0)']
            ]
         }

		   },{
		      type: 'area',
		      name: 'Dislikes',
		      pointInterval: 1*24*60*60*1000,
		      pointStart: Date.UTC(2006, 5, 01),
		      data: lData.dislikes,
		      color: '#7f79fc',
	        fillOpacity: 0.7,
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
ActivityChart.init();
</script>