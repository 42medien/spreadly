<?php use_helper('ChartData') ?>
<div id="chart_line_activities" class="area-chart"></div>
<?php //var_dump(getChartLineActivitiesData($pData, $pCommunity));die();?>
<script type="text/javascript">
var ActivityChart = {
	init: function() {
	  Highcharts.theme = { colors: [] };// prevent errors in default theme
	  var lData = <?php echo json_encode($pData); ?>;
		var lOptions = {
		    chart: {
		      renderTo: 'chart_line_activities',
		      spacingRight: 20,
		      backgroundColor: "#f6f6f6"
		   },
		    title: {
		      text: false
		   },
		    exporting: {
	        enabled: false
	    	},
		   xAxis: {
		      type: 'datetime',
		      title: {
		         text: false
		      }
		   },
		   yAxis: {
		      title: {
		         text: "<?php echo __('Likes'); ?>"
		      },
		      min: 0,
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
		      pointInterval: 1*24*60*60*1000,
		      pointStart: Date.UTC(<?php echo $pFromYear ?>, <?php echo $pFromMonth-1 ?>, <?php echo $pFromDay-1 ?>),
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