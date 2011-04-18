<?php use_helper('ChartData') ?>
<?php //var_dump($pData->getPrefilledLikesByHour()); ?>
<div id="chart_line_activities_by_hour" class="area-chart"></div>
<script type="text/javascript">
var ActivityChart = {
	init: function() {
	  Highcharts.theme = { colors: [] };// prevent errors in default theme
	  var lData = <?php echo json_encode($pData->getPrefilledLikesByHour()); ?>;
		var lOptions = {
		    chart: {
		      renderTo: 'chart_line_activities_by_hour',
		      zoomType: 'x',
		      spacingRight: 20,
		      backgroundColor: "#f6f6f6"
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
		      maxZoom: 7 * 24 * 3600000,
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
		      showFirstLabel: false,
		      allowDecimals:false
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
		      pointInterval: 24,
		      pointStart: 0,
		      data: lData,
		      color: '#1231e3',
	        fillOpacity: 0.1,
	        fillColor: {
            linearGradient: [0, 0, 0, 300],
            stops: [
               [0, Highcharts.theme.colors[0]],
               [1, 'rgba(61,160,242,0)']
            ]
         }
		   }]
		};
		var lChart = new Highcharts.Chart(lOptions);
	}//end init
};//end object
ActivityChart.init();
</script>